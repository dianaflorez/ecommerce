<?php

use app\models\Usuario;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UsuarioSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Usuario', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'usercode',
            'name',
            'lastname',
            'email:email',
            'username',
            //'password',
            //'phone',
            //'document_number',
            'cod_country',
            //'parent_id',
            // 'role',
            // 'status',
            [
                'attribute' => 'role',
                'filter' => \app\models\Usuario::rolesList(),
                'value' => function ($model) {
                    return \app\models\Usuario::rolesList()[$model->role] ?? $model->role;
                },
            ],
            [
                'attribute' => 'status',
                'filter' => \app\models\Usuario::statusList(),
                'value' => function ($model) {
                    return \app\models\Usuario::statusList()[$model->status] ?? $model->status;
                },
            ],
            
            //'active',
            //'active_desc:ntext',
            //'auth_key',
            //'access_token',
            //'created_at',
            //'updated_at',
            //'user_updated',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Usuario $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
