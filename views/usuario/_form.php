<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="usuario-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

    <?php if($model->isNewRecord){ ?>
        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    <?php } ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'identification')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'cod_country')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'usercode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'parent_id')->textInput() ?>

    <?= $form->field($model, 'role')->dropDownList([ 'admin' => 'Admin', 'distributor' => 'Distributor', 'cliente' => 'Cliente', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'status')->dropDownList([ 'pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected', 'active' => 'Active', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'active')->checkbox() ?>

    <?= $form->field($model, 'active_desc')->textarea(['rows' => 3]) ?>



    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
