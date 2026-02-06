<?php    
    namespace app\controllers;
    use Yii;
    use yii\db\Query;
    
    class GlobalController extends \yii\web\Controller
    {
        public function init(){
            parent::init();

        }

        public static function mesnombre($numeromes){
          $mes = ['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
          return $mes[$numeromes-1];
        }

        public static function normalizeName($name)
        {
            $name = mb_strtolower($name, 'UTF-8');
            $name = preg_replace('/\s+/', '', $name);

            // quitar acentos
            $name = iconv('UTF-8', 'ASCII//TRANSLIT', $name);
            $name = preg_replace('/[^a-z0-9]/', '', $name);

            return $name;
        }

        public static function generateUserCode($name)
        {
            $base = self::normalizeName($name);
            $code = $base.time();

            return $code;
        }

        // public function beforeSave($insert)
        // {
        //     if ($insert && empty($this->usercode)) {
        //         $this->usercode = $this->generateUserCode();
        //     }
        //     return parent::beforeSave($insert);
        // }

        public static function referralsSales($userId)
        {

            $rows = (new Query())
                ->select([
                    'u.name AS referido',
                    'i.created_at AS fecha',
                    'i.id AS invoice_id',
                    'i.total AS valor',
                    '(i.total * 0.05) AS comision'
                ])
                ->from('invoice i')
                ->innerJoin('usuario u', 'u.id = i.user_id')
                ->where(['u.parent_id' => $userId])
                ->orderBy(['i.created_at' => SORT_DESC])
                ->all();

            return  $rows;
        }

        public static function ventasxpais(){
            $sql = "
           SELECT
                country,
                vendedor,
                total_vendido
            FROM (
                SELECT
                    c.nombre AS country,
                    u.cod_country,
                    u.name || ' ' || u.lastname AS vendedor,
                    SUM(ii.quantity * ii.price) AS total_vendido,
                    ROW_NUMBER() OVER (
                        PARTITION BY u.cod_country
                        ORDER BY SUM(ii.quantity * ii.price) DESC
                    ) AS ranking
                FROM invoice i
                JOIN usuario u ON u.id = i.user_id
                JOIN invoice_item ii ON ii.invoice_id = i.id
                JOIN country c ON c.cod_country = u.cod_country
                -- WHERE i.status = 'paid'
                GROUP BY u.cod_country, c.nombre, vendedor
            ) ranked
            WHERE ranking = 1
            ORDER BY total_vendido DESC";


            $rows = Yii::$app->db->createCommand($sql)->queryAll();
            return $rows;

        }



        
    }