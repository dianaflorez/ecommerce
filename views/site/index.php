<?php

use rce\material\widgets\Card;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use app\models\Operacion;
use app\models\FuecType;

use yii\helpers\Html;

/* @var $this yii\web\View */

use yii\helpers\Url;

$refLink = Url::to(
    ['/site/referral', 'code' => Yii::$app->user->identity->usercode],
    true
);

$this->title = 'E-Commerce';

$idRole = Yii::$app->user->identity->id_role ?? null;
if ($idRole == 'admin') {
    $this->params['breadcrumbs'][] = ['label' => 'Dashboard', 'url' => ['site/index']];
} else {
    $this->params['breadcrumbs'][] = 'Dashboard';
}
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-index">

    <div class="jumbotron0">
        <h1>E-commerce Prototype</h1>
        <div class="row">
            <div class="col-lg-12">
                <h3>Bienvenido al Dashboard</h3>
                <p>En esta sección encontrarás un resumen de las operaciones y actividades recientes.</p>
            </div>
        </div>
        <!-- <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p> -->
    </div>

    <div class="body-content">

        <?php
        $user = Yii::$app->user->identity;

        if ($user->role === 'cliente' && $user->status == 'pending'): ?>
            <div class="alert alert-warning">
                <b>Tu información está en proceso de verificación para activar tu cuenta como distribuidor.</b>
            </div>
        <?php endif; ?>

        <!-- ADMIN -->
        <?php if( $user->role == 'admin'):  ?>
            <div class="row">
            
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                    
                            <canvas id="productsChart"></canvas>

                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                            <script>
                            const ctx = document.getElementById('productsChart');

                            new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: <?= $labels ?>,
                                    datasets: [{
                                        data: <?= $values ?>
                                    }]
                                }
                            });
                            </script>

                        </div>
                    </div>        

                </div>
            </div>

        <!-- DISTRIBUIDOR -->
        <?php elseif( $user->role == 'distributor'):  ?>
            <div class="row">

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header card-header-info">
                            <h4 class="card-title">
                                <i class="material-icons">share</i> Invita y gana
                            </h4>
                            <p class="card-category">Comparte tu link de referido</p>
                        </div>

                        <div class="card-body">

                            <!-- Link -->
                            <div class="form-group">
                                <input 
                                    type="text" 
                                    id="refLink" 
                                    class="form-control" 
                                    value="<?= $refLink ?>" 
                                    readonly
                                >
                            </div>

                            <!-- Botones -->
                            <div class="text-center">

                                <!-- Copiar -->
                                <button class="btn btn-info btn-round" onclick="copyRefLink()">
                                    <i class="material-icons">content_copy</i> Copiar
                                </button>

                                <!-- WhatsApp -->
                                <?= Html::a(
                                    '<img src="'.Url::base(true).'/images/wpicon.png" width="38"> Compartir',
                                    'https://api.whatsapp.com/send?text=' . urlencode('Regístrate con mi link: ' . $refLink),
                                    ['class' => 'btn btn-link', 'target' => '_blank']
                                ) ?>

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h3>Resumen de Ventas</h3>
                            <p>Total de ventas realizadas: <b><?php // $totalSales ?></b></p>
                            <p>Comisión acumulada: <b>$<?php // number_format($totalCommission, 2, '.', ',') ?></b></p>
                        </div>
                    </div>        
                </div>
            </div>

        <?php endif; ?>


    </div>

</div>

<script>
function copyRefLink() {
    const input = document.getElementById('refLink');
    input.select();
    input.setSelectionRange(0, 99999);
    document.execCommand('copy');

    alert('Link copiado al portapapeles');
}
</script>
