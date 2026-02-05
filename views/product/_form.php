<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Product $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>

    <?php if ($model->isNewRecord){ ?>
        <button class="btn btn-white" onclick="document.getElementById('formuploadimg-file').click()">Photo Product *</button>
        <?= $form->field($uploadModel, 'file')->fileInput(['class'=> 'custom-file-input']) ?>

            <p>* Si tu imagen es muy grande la puedes comprimir en 
            <?= Html::a('https://compressor.io/compress', "https://compressor.io/compress", ['class' => 'enlace', 'target'=>'_blank']); ?>
            </p>
    <?php }  ?>

    <?php if ($model->image): ?>
            <div><img src="<?= Yii::getAlias('@web/archivos/products/' . $model->image) ?>" width="150"></div>
    <?php endif; ?>
    <br>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'price')->textInput(['type' => 'number']) ?>

    <?= $form->field($model, 'is_initial_kit')->checkbox() ?>

    <?= $form->field($model, 'active')->checkbox() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
