<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Invoice $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Invoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$role = Yii::$app->user->identity->role;
?>
<div class="invoice-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?php if ($role === 'admin'): ?>
            <?= Html::a('Invoices', ['index'], ['class' => 'btn btn-info']) ?>
            <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>   
        <?php else: ?>
            <?= Html::a('Invoices', ['index'], ['class' => 'btn btn-info']) ?>
        <?php endif; ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            //'user_id',
            [
                'label' => 'Distribuidor',
                'value' => $model->user_id ? $model->user->fullname : '',
            ],
            'total',
            'type',
            'status',
            'created_at',
        ],
    ]) ?>

</div>
