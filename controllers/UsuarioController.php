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
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
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

    public function actionReferrals()
    {
        $user = Yii::$app->user->identity;

        // Primer nivel
        $children = Usuario::find()
            ->where(['parent_id' => $user->id])
            ->all();

        $data = [];

        // Nodo raíz
        $data[] = [
            'id' => $user->id,
            'name' => $user->name . ' ' . $user->lastname,
        ];

        // Hijos
        foreach ($children as $child) {
            $data[] = [
                'id' => $child->id,
                'name' => $child->name . ' ' . $child->lastname,
                'parent' => $user->id,
            ];
        }

        return $this->render('referrals', [
            'data' => $data,
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
