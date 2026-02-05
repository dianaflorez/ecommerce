<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>


<div class="container">
<div class="row justify-content-center">
<div class="col-md-10">
<div class="card">


<!-- Imagen -->
<div class="card-header card-header-image" style="height:360px; overflow:hidden;">
<img src="<?= Url::base(true) ?>/archivos/products/<?= Html::encode($model->image) ?>"
style="width:100%; height:100%; object-fit:cover;">
</div>


<!-- Contenido -->
<div class="card-body">
<h3 class="card-title">
<?= Html::encode($model->name) ?>
</h3>


<h4 class="text-success">
$<?= number_format($model->price, 2, '.', ',') ?>
</h4>


<?php if ($model->description): ?>
<p class="card-description">
<?= nl2br(Html::encode($model->description)) ?>
</p>
<?php endif; ?>


<hr>


<!-- Acciones -->
<div class="d-flex gap-2">
<?= Html::a(
'<i class="material-icons">shopping_cart</i> Comprar',
['cart/add', 'id' => $model->id],
['class' => 'btn btn-success', 'encode' => false]
) ?>


<?= Html::a(
'<i class="fa-brands fa-whatsapp"></i> Preguntar',
'https://api.whatsapp.com/send?phone=57&text=Hola, estoy interesado en el producto: ' . urlencode($model->name),
['class' => 'btn btn-info', 'target' => '_blank', 'encode' => false]
) ?>
</div>
</div>


<!-- Footer -->
<div class="card-footer">
<small class="text-muted">
Creado el <?= Yii::$app->formatter->asDate($model->created_at) ?>
</small>
</div>


</div>
</div>
</div>
</div>