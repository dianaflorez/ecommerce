<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Productos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="product-view container mt-4">

    <div class="row">

        <!-- COLUMNA IZQUIERDA: IMAGEN -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">
                            <img 
                                src="<?= Url::base(true) . '/archivos/products/' . $model->image ?>" 
                                alt="<?= Html::encode($model->name) ?>"
                                class="img-fluid product-detail-img"
                            >
                        </div>

                        <!-- COLUMNA DERECHA: INFO -->
                        <div class="col-md-8 text-center">
                            <div class="card">
                                <div class="card-body">

                                    <h2 class="title"><b><?= Html::encode($model->name) ?></b></h2>

                                    <h3 class="text-success">
                                        <b>$<?= number_format($model->price, 2, '.', ',') ?></b>
                                    </h3>

                                    <hr>

                                    <?php if ($model->description): ?>
                                        <p>
                                            <strong>Descripción:</strong><br>
                                            <?= nl2br(Html::encode($model->description)) ?>
                                        </p>
                                    <?php endif; ?>

                                    <div class="mt-4">
                                        <?= Html::a(
                                            '<i class="material-icons">shopping_cart</i> Agregar al carrito',
                                            ['invoice/add-to-cart', 'id' => $model->id],
                                            ['class' => 'btn btn-success btn-round']
                                        ) ?>

                                        <?= Html::a(
                                            Html::img(
                                                Yii::getAlias('@web/images/wpicon.png'),
                                                [
                                                    'alt' => 'WhatsApp',
                                                    'style' => 'width:38px; margin-right:0px; vertical-align:middle; background-color: white; border-radius: 80%;'
                                                ]
                                            ) . ' Preguntar',
                                            'https://api.whatsapp.com/send?phone=57',
                                            [
                                                'class' => 'btn btn-link',
                                                'target' => '_blank'
                                            ]
                                        ) ?>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>
