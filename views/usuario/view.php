<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="usuario-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'lastname',
            'email:email',
            'username',
            // 'password',
            'phone',
            'document_number',
            //'cod_country',
            [
                'label' => 'Country',
                'value' => $model->cod_country ? $model->codCountry->nombre : '',
            ],
            'usercode',
            // 'parent_id',
            [
                'label' => 'Referido por',
                'value' => $model->parent_id && $model->parent ? $model->parent->fullname : '',
            ],
            'role',
            'status',
            'active:boolean',
            'active_desc:ntext',
            //'auth_key',
            //'access_token',
            'created_at',
            'updated_at',
            [
                'label' => 'Usuario quien modifico la ultima vez',
                'value' => $model->updatedBy ? $model->updatedBy->fullname : '',
            ],
        ],
    ]) ?>

</div>
