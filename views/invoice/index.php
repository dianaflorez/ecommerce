<?php

use app\models\Invoice;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\Usuario;
use app\models\User;

/** @var yii\web\View $this */
/** @var app\models\InvoiceSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Invoices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            // User::isAdmin(Yii::$app->user->identity->id) ? [
            //     'attribute' => 'userName',
            //     'label' => 'Usuario',
            //     'value' => function ($model) {
            //         return $model->user
            //             ? $model->user->name . ' ' . $model->user->lastname
            //             : '';
            //     },
            // ] : null,

            [
                'attribute' => 'userName',
                'label' => 'Usuario',
                'value' => function ($model) {
                    return $model->user
                        ? $model->user->name . ' ' . $model->user->lastname
                        : '';
                },
            ],
            
            'total',
            'type',
            'status',
            //'created_at',
            [
                'class' => ActionColumn::class,
                'template' => Yii::$app->user->identity->role === Usuario::ROLE_ADMIN
                    ? '{view} {update}'
                    : '{view}',
                'urlCreator' => function ($action, Invoice $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                },
            ],
        ],
    ]); ?>


</div>
