<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Product $model */

$this->title = 'Create Product';
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <div class="card">
        <div class="card-body">
        <h2><?= Html::encode($this->title) ?></h2>
        <br>

        <?= $this->render('_form', [
            'model' => $model,
            'uploadModel' => $uploadModel,
        ]) ?>
        </div>
    </div>
</div>
