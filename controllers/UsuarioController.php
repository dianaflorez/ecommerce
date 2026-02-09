<?php

namespace app\controllers;

use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\ArrayHelper;


// For AccessControl
use app\models\User;
use yii\filters\AccessControl;
use Yii;

use yii\helpers\Url;

use Mpdf\Mpdf;

$mpdf = new Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'tempDir' => Yii::getAlias('@runtime/mpdf'),
]);

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
      return [
        'access' => [
            'class' => AccessControl::className(),
            'only' => ['index', 'update','view'],
            'rules' => [
                [
                   //Los usuarios simples tienen permisos sobre las siguientes acciones
                   'actions' => ['index', 'update','view'],
                   //Esta propiedad establece que tiene permisos
                   'allow' => true,
                   //Usuarios autenticados, el signo ? es para invitados
                   'roles' => ['@'],
                   //Este método nos permite crear un filtro sobre la identidad del usuario
                   //y así establecer si tiene permisos o no
                   'matchCallback' => function ($rule, $action) {
                      //Llamada al método que comprueba si es un usuario simple
                      return User::isAdmin(Yii::$app->user->identity->id);
                  },
               ],
                [
                   //Los usuarios simples tienen permisos sobre las siguientes acciones
                   'actions' => [''],
                   //Esta propiedad establece que tiene permisos
                   'allow' => true,
                   //Usuarios autenticados, el signo ? es para invitados
                   'roles' => ['@'],
                   //Este método nos permite crear un filtro sobre la identidad del usuario
                   //y así establecer si tiene permisos o no
                   'matchCallback' => function ($rule, $action) {
                      //Llamada al método que comprueba si es un usuario simple
                      return User::isDistribuidor(Yii::$app->user->identity->id);
                  },
               ],
               [
                  //Los usuarios simples tienen permisos sobre las siguientes acciones
                  'actions' => [''],
                  //Esta propiedad establece que tiene permisos
                  'allow' => true,
                  //Usuarios autenticados, el signo ? es para invitados
                  'roles' => ['@'],
                  //Este método nos permite crear un filtro sobre la identidad del usuario
                  //y así establecer si tiene permisos o no
                  'matchCallback' => function ($rule, $action) {
                     //Llamada al método que comprueba si es un usuario simple
                     return User::isCliente(Yii::$app->user->identity->id);
                 },
              ]
            ],
        ],
         //Controla el modo en que se accede a las acciones, en este ejemplo a la acción logout
         //sólo se puede acceder a través del método post
        'verbs' => [
            'class' => VerbFilter::className(),
            'actions' => [
                'logout' => ['post'],
            ],
        ],
      ];
    }

    /**
     * Lists all Usuario models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Usuario();
        $usuarios = Usuario::find()
                ->where(['active' => 1])
                ->andWhere(['not in', 'role', ['admin', 'cliente']])
                ->andWhere(['not', ['id' => $model->id]])
                ->orderBy('name ASC')
                ->all();
            
        $listaUsuarios = ArrayHelper::map(
            $usuarios,
            'id',
            function ($user) {
                return $user->name . ' ' . $user->lastname . ' (' . $user->usercode . ')';
            }
        );

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {

                $model->password = Yii::$app->security->generatePasswordHash($model->password);

                if($model->save()){
                    Yii::$app->session->setFlash('success', 'Registro exitoso. Espera aprobación.');

                    return $this->redirect(['view', 'id' => $model->id]);

                } else {
                    $error = json_encode( $model->getErrors() );
                    $msg = "No se pudo guardar la información $error";
                    Yii::$app->session->setFlash('error', 'Error al guardar el usuario. '.$msg);

                }

            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'listaUsuarios' => $listaUsuarios,
        ]);
    }

    /**
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $usuarios = Usuario::find()
                ->where(['active' => 1])
                ->andWhere(['not in', 'role', ['admin', 'cliente']])
                ->andWhere(['not', ['id' => $model->id]])
                ->orderBy('name ASC')
                ->all();
            
        $listaUsuarios = ArrayHelper::map(
            $usuarios,
            'id',
            function ($user) {
                return $user->name . ' ' . $user->lastname . ' (' . $user->usercode . ')';
            }
        );

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'listaUsuarios' => $listaUsuarios,
        ]);
    }

    public function actionContrato($id)
    {
        $model = $this->findModel($id);

        $html = $this->renderPartial('contrato-pdf', [
            'model' => $model,
        ]);

        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
        ]);

        $mpdf->WriteHTML($html);
        $mpdf->Output(
            'Contrato_'.$model->usercode.'.pdf',
            \Mpdf\Output\Destination::INLINE
        );
    }

    // CAMBIAR CLAVE
    public function actionCambiarClave($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $nuevaClave = Yii::$app->request->post('nueva_clave');

            if (!empty($nuevaClave)) {
                $model->password = Yii::$app->security
                    ->generatePasswordHash($nuevaClave);

                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'Clave actualizada');
                    return $this->redirect(['index']);
                }
            }

            Yii::$app->session->setFlash('error', 'La clave no puede estar vacía');
        }

        return $this->render('cambiar-clave', [
            'model' => $model,
        ]);
    }




    public $binario =[];

    function hijobinario($usuarios, $id){
      $hijos = [];
      foreach ($usuarios as $value) {
        if($value["parent_id"] == $id ){
          array_push($this->binario, $value);
          $hijos = $this->hijobinario($usuarios, $value["id"]);
        }
      }
      return $hijos;
    }
    public function actionReferrals($msg = null, $id = null){
        $this->layout='main';

        if(Yii::$app->user->identity->role != 'admin' || $id == null){
            $id = Yii::$app->user->identity->id;
        } 

        if(Yii::$app->user->identity->role == 'admin' || $id == null){
            $id = Usuario::find()->where(['role' => 'distributor'])->orderBy('id ASC')->one()->id;
        } 

        $model = Usuario::findOne($id);
        $usuprimero = $model;


        $usuario = Usuario::find()->andWhere("role='distributor'")->all();
        
        // $usuario = Usuario::find()->andWhere('id>='.$id)->orderBy(['position_binario' => SORT_DESC])->all();
        
        //$usuario = GlobalController::hijosinfBinario($id);
        //$out=[['v' => '..'],'Mike', 'VP'];

        array_push($this->binario, $usuprimero);

        $hijos = $this->hijobinario($usuario, $id);

        $out=[];
        $swprimero = 1;
        $avatarDefault = Url::base()."/images/user.png";

        foreach ($this->binario as $value) {
            //$avatar = $value["avatar"] ? Url::base()."/archivos/".$value["avatar"] : $avatarDefault;
            $avatar =  $avatarDefault;
            
            //$out [] = [  'v'=> $value["name"]  ,'Mike', 'VP'];
            $nombre = $value["name"].' '.$value["lastname"];
            $idusuario = (string)$value["id"];
            //$lado = strtoupper($value["position_binario"]);
            //$padre = Usuario::findOne($value["id_padre_inscripcion_uninivel"]);
            //$padre_row = Usuario::findOne($value["id_padre_inscripcion_uninivel"]);
            //$padre = $padre_row["name"].' '.$padre_row["lastname"];
            $padre = (string) $value["parent_id"];
            if($swprimero == 1){
                $padre = '';
                $swprimero ++;
            }
            array_push($out, [['v'=>$idusuario, 'f' => '<img src="'.$avatar.'" height="42" /><br/> <strong>' . $nombre .' '.$idusuario.' '. '</strong><br/>' . '<br>' . $value["usercode"] .''],  $padre , $nombre]);

        }

        return $this->render('referrals', [
                                        'model' => $model,
                                        "msg"   => $msg,
                                        "out"   => $out,
                                        "usuarios" => $usuario
                                ]);
    }

        

    public function actionReferralsChart()
    {
        $user = Yii::$app->user->identity;

        if($user->role == 'distributor') {
            // Solo referidos directos
            $all = Usuario::find()
                ->where(['id' => $user->id])               // el padre
                ->orWhere(['parent_id' => $user->id])      // los hijos
                ->andWhere(['role' => 'distributor'])
                ->all();

        } else {
             // todos los referidos
            $all = Usuario::find()->andWhere("role='distributor'")->all();
        }
        
        $nodes = [];
        foreach ($all as $u) {
            $nodes[] = [
                'id' => $u->id,
                'pid' => $u->parent_id ?? null,
                'name' => $u->fullName,
                'title' => $u->parent_id ? 'Referido de ' . ($u->parent->fullName ?? 'N/A') : 'Usuario Raíz',
            ];
        }


        return $this->render('referrals-chart', [
            'data' => json_encode($nodes),
        ]);
    }


    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
