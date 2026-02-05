<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */

$this->title = 'Create Usuario';
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="usuario-create">

    <div class="card">
        <div class="card-body">
            <h2><?= Html::encode($this->title) ?></h2>
            <br>
            <?= $this->render('_form', [
                'model' => $model,
                'listaUsuarios' => $listaUsuarios,

            ]) ?>

        </div>
    </div>
</div>
