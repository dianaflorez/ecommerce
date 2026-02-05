<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $searchModel app\models\invoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Carrito de compras';
$this->params['breadcrumbs'][] = $this->title;
?>
<h4>
    <?php
        if( !$msgtipo ){
        $msgtipo = 'info';
        } 
        if($msg){
        echo Alert::widget([
            'options' => [
                'class' => 'alert alert-'.$msgtipo,
            ],
            'body' => $msg,
        ]);
        }
    ?>
</h4>


<div class="invoice-index">

<div class="row">
  <div class="col-md-12">
      <div class="card">
          <div class="card-header-icon card-header-rose">
            <div class="card-icon cart-icon-div">
                
                <i class="material-icons cart-icon">shopping_cart</i>

            </div>
          </div>

          <div class="card-body card-cart-content">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
                <p class="card-title">* Solo se pueden agregar productos de un solo proveedor, si desea productos de otro proveedor debe hacerlo en otra orden de compra, gracias.</p>
                  
                <!-- CART -->

                <div class=" width-cart">
                    <table class="table table-shopping ">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-center">Producto</th>
                                <th class="text-center">Cantidad</th>
                                <th class="text-center">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $ctproducts = 0;
                                $subtotal = 0;
                                $total = 0;
                                $envio_value = 0;
                            ?>
                            <?php foreach($cart as $c ){ ?>
                                <?php $form = ActiveForm::begin(['validateOnSubmit' => false,'action' => ['invoice/cart'],'options' => ['method' => 'post']]) ?>

                            <tr>
                                <td>
                                    <div class="img-container">
                                        <img src="<?= Url::base(true)?>/archivos/products/<?=$c['image']?>" alt="<?= $c['item_name']?>">
                                    </div>
                                </td>
                                <td>
                                   <a href="#jacket"><?= $c['item_name'] ?></a>
                                   <br><small><?= isset($c['main_desc']) ? $c['main_desc'] : '' ?></small>
                                </td>
                                <td class="td-number text-right" >
                                    <!--CANTIDAD -->
                                    <?= $c['item_quantity']?>

                                    <input type="hidden" id="invoice-id" name="invoice[id]" readonly value=<?=$c['product_id']?>>
                                    <div class="btn-group">
                                        <?= Html::a(
                                            '<i class="material-icons">remove</i>',
                                            ['invoice/cartremove/'.$c['product_id']],
                                            ['class' => 'btn btn-round btn-info btn-sm']
                                        ) ?>
                                        <?= Html::a(
                                            '<i class="material-icons">add</i>',
                                            ['invoice/cartadd/'.$c['product_id']],
                                            ['class' => 'btn btn-round btn-info btn-sm']
                                        ) ?>
                                        
                                    </div>
                                    <!-- FIN CANTIDAD -->
                                    <?php
                                        // setlocale(LC_MONETARY, 'en_US.UTF-8');
                                        // $price = money_format('%.0n', $c['price']);

                                        $formatted = number_format($c['price'], 2, '.', ','); 
                                        $price = '$' . $formatted;
                                        echo $price;
                                    ?>
                                </td>
                                <td class="td-number text-right table-uno">
                                        <?php
                                            setlocale(LC_MONETARY, 'en_US.UTF-8');
                                            $itemqty = $c['price'] * $c['item_quantity'];

                                            
                                            $formatted = number_format($itemqty, 2, '.', ','); 
                                            $item_total = $formatted;
                                            echo $item_total;
                                        ?>
                                         
                                </td>
                                <td>
                                    <?= Html::a(
                                        '<i class="material-icons">close</i>',
                                        ['invoice/cartdelete/'.$c['product_id']],
                                        [
                                            'class' => 'btn btn-simple btn-default btn-eliminar',
                                            'rel'=>"tooltip",
                                            'data-placement'=>"left",
                                            'title'=>"Eliminar item"
                                        ]
                                    ) ?>
                                    
                                </td>
                               
                            </tr>
                            <?php
                            if($c['domicilio_valor'] > $envio_value){
                                $envio_value = $c['domicilio_valor'];
                            }
                            ?>
                            <?php ActiveForm::end(); ?>
                                    <?php
                                        $ctproducts = $c['item_quantity'] + $ctproducts;
                                        $subtotal = $itemqty + $subtotal;
                                        $total = $envio_value + $subtotal;
                                    ?>
                            <?php } ?>
                                <tr>
                                <td colspan=3 class="td-number text-right table-subtitle table-divisor">
                                    Cantidad de producto(s)
                                
                                    <?= $ctproducts ?>
                                </td>
                                <td colspan=2 class="td-number text-right">
                                    <?php
                                        // setlocale(LC_MONETARY, 'en_US.UTF-8');
                                        // $subtotal = money_format('%.0n', $subtotal);

                                        $formatted = number_format($subtotal, 2, '.', ','); 
                                        $subtotal = '$' . $formatted;
                                        echo $subtotal;
                                    ?>
                                </td>
                                </tr>
                                <tr>
                                    <td colspan=3 class="td-number text-right table-subtitle">
                                        Valor de Envio
                                    </td>
                                    <td colspan=2  class="td-number text-right">
                                        <?php
                                            // setlocale(LC_MONETARY, 'en_US.UTF-8');
                                            // $envio_value = money_format('%.0n', $envio_value);

                                            $formatted = number_format($envio_value, 2, '.', ','); 
                                            $envio_value = '$' . $formatted;
                                            echo $envio_value;
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan=3 class="td-number text-right table-subtitle">
                                        TOTAL
                                    </td>
                                    <td colspan=2 class="td-number text-right">
                                            <?php
                                                // setlocale(LC_MONETARY, 'en_US.UTF-8');
                                                // $total = money_format('%.0n', $total);


                                                $formatted = number_format($total, 2, '.', ','); 
                                                $total = '$' . $formatted;
                                                echo "<b>$total</b>";
                                            ?>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan=5 class="td-number text-right text-success table-botones">
                                        <p>
                                            <?= Html::a('Agregar mas products', ['product/products'], ['class' => 'btn btn-info']) ?>
                                            <?= Html::a('Limpiar Carrito', ['cart', 'clean' => true], ['class' => 'btn btn-primary']) ?>

                                            <?= Html::a('Realizar pago', ['create'], ['class' => 'btn btn-success']) ?>
                                        </p>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
            </div>
            <!-- Fin Carrito de compras -->

          </div>
      </div>
  </div>

    

</div>
