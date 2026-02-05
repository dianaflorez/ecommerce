<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Invoice $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="invoice-form">

    <?php $form = ActiveForm::begin(); ?>

        <div class="card">
            <div class="card-header">
                <h3>Your Cart</h3>      
                <h4 class="card-title">Resumen de compra</h4>
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="card-content">

                        <div class="table-responsive">
                            <table class="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $total = 0;
                                    foreach ($cart as $item):
                                        $subtotal = $item['price'] * $item['item_quantity'];
                                        $total += $subtotal;
                                    ?>
                                        <tr>
                                            <td><?= $item['item_name'] ?></td>
                                            <td><?= $item['item_quantity'] ?></td>
                                            <td>$<?= number_format($item['price'], 2) ?></td>
                                            <td>$<?= number_format($subtotal, 2) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right">TOTAL</th>
                                        <th>$<?= number_format($total, 2) ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php if ($model->isNewRecord): ?>
            <?= $form->field($model, 'user_id')->hiddenInput()->label(false) ?>
        <?php else: ?>
            
            <?php // $form->field($model, 'total')->textInput() ?>

            <?= $form->field($model, 'type')->dropDownList([ 'initial' => 'Initial', 'regular' => 'Regular', ], ['prompt' => '']) ?>

            <?= $form->field($model, 'status')->dropDownList([ 'pending' => 'Pending', 'paid' => 'Paid', 'cancelled' => 'Cancelled', ], ['prompt' => '']) ?>

        <?php endif; ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar Pago', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
