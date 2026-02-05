<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\controllers\GlobalController;


/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = 'Productos';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container-fluid">
    <div class="row">

        <?php foreach ($products as $p): ?>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <a href="info/<?= $p->id ?>" style="text-decoration: none;">
                    <div class="card card-product">

                        <!-- Imagen -->
                        <div class="card-header card-header-image">
                            <img class="img"
                                src="<?= Url::base(true) ?>/archivos/products/<?= $p->image ?>">
                        </div>

                        <!-- Body -->
                        <div class="card-body">
                            <?php
                                $price = '$' . number_format($p->price, 2, '.', ',');
                            ?>

                            <h4 class="card-title">
                                <?= Html::encode($p->name) ?>
                                <small class="text-success"><?= $price ?></small>
                            </h4>

                            <?php if ($p->description): ?>
                                <p class="card-description">
                                    <?= Html::encode($p->description) ?>
                                </p>
                            <?php endif; ?>
                        </div>

                        <!-- Footer -->
                        <div class="card-footer mt-auto">
                            <?= Html::a(
                                '<i class="material-icons">shopping_cart</i> Comprar',
                                ['invoice/cart', 'id' => $p->id],
                                ['class' => 'btn btn-success btn-sm']
                            ) ?>
                            
                        </div>

                    </div>
                </a>
            </div>
        <?php endforeach; ?>

    </div>
</div>
