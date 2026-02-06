<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Usuario;
use app\controllers\GlobalController;


use yii\db\Query;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }


        // Grafica
        $data = (new Query())
            ->select([
                'p.name AS product',
                'SUM(ii.quantity) AS total_products'
            ])
            ->from('invoice_item ii')
            ->innerJoin('product p', 'p.id = ii.product_id')
            ->groupBy('p.id, p.name')
            ->orderBy(['total_products' => SORT_DESC])
            ->all();

        $labels = [];
        $values = [];

        foreach ($data as $row) {
            $labels[] = $row['product'];
            $values[] = (int)$row['total_products'];
        }

        return $this->render('index', [
            'labels' => json_encode($labels),
            'values' => json_encode($values),
        ]);
        // fin GRAFICA

    }

    public function actionRegister($id = null)
    {
        $model = new Usuario();
        if($id !== null){
            $padre= Usuario::findOne($id);
        }
        $refUserId = Yii::$app->session->get('ref_user_id');
        if ($refUserId) {
            $model->parent_id = $refUserId;
            $padre= Usuario::findOne($refUserId);

        }


        if ($model->load(Yii::$app->request->post())) {

            // valores por defecto
            $model->role = Usuario::ROLE_CLIENTE;
            $model->status = Usuario::STATUS_PENDING;
            $model->active = 1;
            $model->usercode = GlobalController::generateUserCode($model->name);
            // ⚠️ IMPORTANTE: hashear password
            $model->password = Yii::$app->security->generatePasswordHash($model->password);
            $model->auth_key = Yii::$app->security->generateRandomString();

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Registro exitoso. Espera aprobación.');
                // return $this->redirect(['site/login']);

                // 🔥 AUTO LOGIN                
                $usuario = Usuario::findOne($model->id); // o como lo obtengas
                $identity = new \app\models\User($usuario);
                Yii::$app->user->login($identity);
                
                return $this->redirect(['site/index']);
            } else {

                Yii::$app->session->setFlash('error', 'Error en el registro. Por favor, verifica los datos.');
                $error = json_encode( $model->getErrors() );
                $msg = "No se pudo editar la información $error";
                Yii::$app->session->setFlash('error', 'Error al guardar el conductor. '.$msg);
            }
        }

        return $this->render('register', [
            'model' => $model,
            'padre' => $padre ?? null,
        ]);
    }

    public function actionReferral($code)
    {
        $user = Usuario::find()
            ->where(['usercode' => $code, 'active' => 1])
            ->one();

        if (!$user) {
            throw new \yii\web\NotFoundHttpException('Referido no válido');
        }

        // Guardar referido en sesión
        Yii::$app->session->set('ref_user_id', $user->id);

        // Redirigir al registro
        return $this->redirect(['site/register']);
    }


    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
        
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
