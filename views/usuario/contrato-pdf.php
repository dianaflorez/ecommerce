<?php
/* @var $model app\models\Usuario */
?>

<style>
body {
    font-family: sans-serif;
    font-size: 12px;
}
h1 {
    text-align: center;
}
.firma {
    margin-top: 55px;
}
</style>


<br>
<br>
<br>

<h1>CONTRATO DE DISTRIBUCIÓN</h1>
<br>
<br>
<br>
<p>
En la fecha <?= date('d/m/Y') ?>, se certifica que:
</p>
<br>

<p>
<strong>Nombre:</strong> <?= $model->name ?> <?= $model->lastname ?><br>
<strong>Identificación:</strong> <?= $model->identification ?><br>
<strong>Código de usuario:</strong> <?= $model->usercode ?>
</p>
<br>

<p>
Ha sido <strong>APROBADO COMO DISTRIBUIDOR</strong>, cumpliendo con los
requisitos establecidos por la compañía y quedando autorizado para
representar y distribuir los productos según las políticas vigentes.
</p>

<p>
Este contrato tiene validez a partir de la fecha de emisión.
</p>

<div class="firma">
<p>______________________________</p>
<p><strong>Firma Autorizada</strong></p>
</div>
