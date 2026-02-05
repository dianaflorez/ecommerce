<?php

namespace app\controllers;

use app\models\Product;
use app\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

// Upload de imágenes
use app\models\FormUploadImg;
use yii\web\UploadedFile;

// For AccessControl
use app\models\User;
use yii\filters\AccessControl;
use Yii;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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

    public function actionInfo($id)
    {
        return $this->render('info', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionProducts()
    {
        return $this->render('products', [
            'products' => Product::find()->all(),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();
        $model->is_initial_kit = 0;
        $model->active = 1;

        $uploadModel = new FormUploadImg();

        if ($model->load(Yii::$app->request->post())) {
    
             $uploadModel->file = UploadedFile::getInstance($uploadModel, 'file');
           
            if ($uploadModel->file && $uploadModel->validate()) {
                $path = 'archivos/products/';
                $nameimg = 'pr';
                $imagePath = $uploadModel->upload($path, $nameimg);
    
                if ($imagePath === false) {
                    return $this->render('create', [
                        'model' => $model,
                        'uploadModel' => $uploadModel
                    ]);
                }
    
                $model->image = $imagePath;
                if ($model->save()) {
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $error = json_encode( $model->getErrors() );
                    $msg = "No se pudo editar la información $error";
                    Yii::$app->session->setFlash('error', 'Error al guardar el conductor. '.$msg);

                }
            } else {
                $error = json_encode( $uploadModel->getErrors() );
                $msg = "No se pudo subir la imagen $error";
                Yii::$app->session->setFlash('error', 'Error al subir la imagen. '.$msg);
            }
    
            
        }
    
        return $this->render('create', [
            'model' => $model,
            'uploadModel' => $uploadModel
        ]);
    
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
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
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
