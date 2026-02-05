<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = 'Update Usuario: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="usuario-update">
    <div class="card">
        <div class="card-body">

            <h2><?= Html::encode($this->title) ?></h2>

            <?= $this->render('_form', [
                'model' => $model,
                'listaUsuarios' => $listaUsuarios,
                ]) ?>

        </div>
    </div>
</div>
