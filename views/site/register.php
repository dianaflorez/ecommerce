<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Country;

$this->title = 'Registro';
?>

<div class="site-register">
    <div class="col-md-6 ml-auto mr-auto">
        <div class="card">
            <div class="card-header card-header-info text-center">
                <h4 class="card-title">Registro</h4>
            </div>

            <?php $form = ActiveForm::begin(); ?>

            <div class="card-body">

                <?= $form->field($model, 'name')->textInput() ?>
                <?= $form->field($model, 'lastname')->textInput() ?>
                <?= $form->field($model, 'identification')->textInput() ?>
                <?= $form->field($model, 'email')->input('email') ?>
                <?= $form->field($model, 'username')->textInput() ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'phone')->textInput() ?>
                <?= $form->field($model, 'cod_country')->dropDownList(
                    ArrayHelper::map(
                        Country::find()->where(['active' => true])->orderBy('nombre')->all(),
                        'cod_country',
                        'nombre'
                    ),
                    ['prompt' => 'Seleccione país']
                ) ?>


                <!-- Role oculto si solo se registra distributor -->
                <?= $form->field($model, 'role')->hiddenInput([
                    'value' => \app\models\Usuario::ROLE_DISTRIBUTOR
                ])->label(false) ?>

            </div>

            <div class="card-footer text-center">
                <?= Html::submitButton('Crear cuenta', ['class' => 'btn btn-success']) ?>
                <?= Html::a('Volver al login', ['site/login'], ['class' => 'btn btn-default']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
