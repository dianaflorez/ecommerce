<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<h2>Cambiar clave</h2>

<h3>Se cambiará la clave para el usuario: </h3>
<h3>
    <b><?= $model->username ?></b>
    <?= $model->fullName ?>
</h3>
<br>
<br>

<form method="post">
    <?= Html::hiddenInput(
        Yii::$app->request->csrfParam,
        Yii::$app->request->csrfToken
    ) ?>

    <div class="form-group">
        <label>Nueva contraseña</label>
        <input type="password" name="nueva_clave" class="form-control">
    </div>

    <button class="btn btn-primary">Guardar</button>
</form>
