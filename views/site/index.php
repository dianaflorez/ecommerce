<?php

use rce\material\widgets\Card;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

use app\models\Operacion;
use app\models\FuecType;

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = 'Diana';

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

        <?php endif; ?>


    </div>

</div>
