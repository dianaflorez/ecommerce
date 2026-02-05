<?php

namespace app\controllers;

use app\models\Invoice;
use app\models\InvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\Product;
use app\models\InvoiceItem;
use app\models\Usuario;


// For AccessControl
use app\models\User;
use yii\filters\AccessControl;
use Yii;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
      return [
        'access' => [
            'class' => AccessControl::className(),
            'only' => ['index', 'create', 'update','view','cart', 'viewinvoice'],
            'rules' => [
                [
                   //Los usuarios simples tienen permisos sobre las siguientes acciones
                   'actions' => ['index', 'create', 'update','view','cart'],
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
                   'actions' => ['cart', 'create', 'view', 'index'],
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
     * Lists all Invoice models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $user = Yii::$app->user->identity;

        if ($user->role === Usuario::ROLE_DISTRIBUTOR && $model->user_id != $user->id) {
            throw new ForbiddenHttpException('No tienes permiso para ver esta factura');
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        // 1. Verificar sesión de carrito
        $cart = Yii::$app->session->get('cart');

        if (empty($cart)) {
            Yii::$app->session->setFlash('error', 'El carrito está vacío');
            return $this->redirect(['/product/index']);
        }

        // 2. Calcular total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['item_quantity'];
        }

        // 3. Crear factura
        $model = new Invoice();
        $model->user_id = Yii::$app->user->identity->id;
        $model->total = $total;
        $model->type = 'initial'; // o 'online', 'manual', etc.
        $model->status = 'pending';

             // 4. Guardar factura y detalles
            if ($model->load($this->request->post())) {
                if ($model->save()) {

                    foreach ($cart as $item) {
                        $detail = new InvoiceItem();
                        $detail->invoice_id = $model->id;
                        $detail->product_id = $item['product_id'];
                        $detail->quantity = $item['item_quantity'];
                        $detail->price = $item['price'];
                        $detail->save(false);
                    }
                    
                    // 5. Limpiar carrito
                    Yii::$app->session->remove('cart');
            
                    Yii::$app->session->setFlash(
                        'success',
                        'Pago iniciado correctamente. Pedido generado.'
                    );
            
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $error = json_encode( $model->getErrors() );
                    $msg = "No se pudo editar la información $error";
                    Yii::$app->session->setFlash('error', 'Error al guardar el conductor. '.$msg);

                }
            }
       

        return $this->render('create', [
            'model' => $model,
            'cart' => $cart,
        ]);
    }

    /**
     * Updates an existing Invoice model.
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

    public function actionCart($id=null , $msg = null, $msgtipo = null, $clean = null)
    {
        $model = new Invoice();
        $products = [];
        $proveedor = "";
        $proveedorLogo = null;
        // var_dump($_SESSION);

        if ($clean){
            unset($_SESSION['cart']);
        }
       
        $product = Product::findOne($id);
        if( $id ){
            if (isset($_SESSION["cart"]) ){

                
                $item_array_id = array_column($_SESSION["cart"],"product_id");
                if (!in_array($id, $item_array_id)){
            
                    $count = count($_SESSION["cart"]);
                    $item_array = array(
                        'product_id' => $id,
                        'item_name' => $product->name,
                        'main_desc' => $product->description,
                        'image' => $product->image,
                        'price' => $product->price,
                        'stock' => 9999000,
                        'domicilio_valor' => 0,
                        'item_quantity' => 1,
                    );
                    $_SESSION["cart"][$product->id] = $item_array;
                // $_SESSION["cart"]['count'] = $count;

                //  echo '<script>window.location="Cart.php"</script>';
                }
               
                
            } else {
                // echo '<script>alert("Product new")</script>';

                $item_array = array(
                    'product_id' => $product->id,
                    'item_name' => $product->name,
                    'main_desc' => $product->description,
                    'image' => $product->image,
                    'price' => $product->price,
                    'stock' => 99999000,
                    'domicilio_valor' => 0,
                    'item_quantity' => 1,
                );
                $_SESSION["cart"][$product->id] = $item_array;
            }
        }
    
        $cart = isset($_SESSION["cart"]) ? $_SESSION["cart"] : [];
        // Los productos del proveedor seleccionado
        if (isset($_SESSION['cart'])){
            $products = Product::find()
                                //->where('usuario.active = 1')
                                ->andWhere('product.active = true')
                                //->andWhere('id_category != 0')
                                ->all();
        } 
        return $this->render('cart', [
            'model' => $model,
            'cart' => $cart ,
            'msg' => $msg,
            'msgtipo' => $msgtipo,
            'products' => $products,
            
        ]);
    }

    public function actionCartremove($id)
    {
        if (!isset($_SESSION['cart'][$id])) {
            return $this->redirect(['invoice/cart']);
        }

        // Disminuir cantidad
        
        $_SESSION['cart'][$id]['item_quantity']--;

        // Si llega a 0, eliminar el producto
        if ($_SESSION['cart'][$id]['item_quantity'] <= 0) {
            unset($_SESSION['cart'][$id]);
        }

        return $this->redirect(['invoice/cart']);
    }

    public function actionCartadd($id)
    {
        if (!isset($_SESSION['cart'])) {
            return $this->redirect(['invoice/cart']);
        }

        $_SESSION['cart'][$id]['item_quantity']++;

        return $this->redirect(['invoice/cart']);
    }

    public function actionCartdelete($id)
    {
        if (!isset($_SESSION['cart'])) {
            return $this->redirect(['invoice/cart']);
        }

        unset($_SESSION['cart'][$id]);

        return $this->redirect(['invoice/cart']);
    }



    /**
     * Deletes an existing Invoice model.
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
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
