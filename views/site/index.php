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

                <div class="col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header card-header-warning">
                        <h4 class="card-title">Ultimas Ventas</h4>
                        <p class="card-category">Ventas realizadas Febrero, 2026</p>
                        </div>
                        <div class="card-body table-responsive">
                        <table class="table table-hover">
                            <thead class="text-warning">
                            <th>ID</th>
                            <th>Quien mas a vendido</th>
                            <th>Ventas Totales x Pais</th>
                            <th>Pais</th>
                            </thead>
                            <tbody>
                                <?php $ct = 1; foreach($ventasxpais as $vp): ?>
                                    <tr>
                                        <td><?= $ct++; ?></td>
                                        <td><?= $vp['vendedor'] ?></td>
                                        <td>$<?= number_format($vp['total_vendido'], 2) ?></td>
                                        <td><?= $vp['country'] ?></td>
                                    </tr>   
                                <?php endforeach; ?>
                            
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>

                <div class="col-md-12"><hr><h3>Chart Examples</h3> </div>
                <div class="col-md-4">
                    <div class="card card-chart">
                        <div class="card-header card-header-warning">
                            <div class="ct-chart" id="websiteViewsChart2"><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-bar" style="width: 100%; height: 100%;"><g class="ct-grids"><line y1="120" y2="120" x1="40" x2="285" class="ct-grid ct-vertical"></line><line y1="96" y2="96" x1="40" x2="285" class="ct-grid ct-vertical"></line><line y1="72" y2="72" x1="40" x2="285" class="ct-grid ct-vertical"></line><line y1="48" y2="48" x1="40" x2="285" class="ct-grid ct-vertical"></line><line y1="24" y2="24" x1="40" x2="285" class="ct-grid ct-vertical"></line><line y1="0" y2="0" x1="40" x2="285" class="ct-grid ct-vertical"></line></g><g><g class="ct-series ct-series-a"><line x1="50.208333333333336" x2="50.208333333333336" y1="120" y2="54.959999999999994" class="ct-bar" ct:value="542" opacity="1"></line><line x1="70.625" x2="70.625" y1="120" y2="66.84" class="ct-bar" ct:value="443" opacity="1"></line><line x1="91.04166666666667" x2="91.04166666666667" y1="120" y2="81.6" class="ct-bar" ct:value="320" opacity="1"></line><line x1="111.45833333333333" x2="111.45833333333333" y1="120" y2="26.400000000000006" class="ct-bar" ct:value="780" opacity="1"></line><line x1="131.875" x2="131.875" y1="120" y2="53.64" class="ct-bar" ct:value="553" opacity="1"></line><line x1="152.29166666666669" x2="152.29166666666669" y1="120" y2="65.64" class="ct-bar" ct:value="453" opacity="1"></line><line x1="172.70833333333334" x2="172.70833333333334" y1="120" y2="80.88" class="ct-bar" ct:value="326" opacity="1"></line><line x1="193.12500000000003" x2="193.12500000000003" y1="120" y2="67.92" class="ct-bar" ct:value="434" opacity="1"></line><line x1="213.54166666666669" x2="213.54166666666669" y1="120" y2="51.84" class="ct-bar" ct:value="568" opacity="1"></line><line x1="233.95833333333334" x2="233.95833333333334" y1="120" y2="46.8" class="ct-bar" ct:value="610" opacity="1"></line><line x1="254.37500000000003" x2="254.37500000000003" y1="120" y2="29.28" class="ct-bar" ct:value="756" opacity="1"></line><line x1="274.7916666666667" x2="274.7916666666667" y1="120" y2="12.599999999999994" class="ct-bar" ct:value="895" opacity="1"></line></g></g><g class="ct-labels"><foreignObject style="overflow: visible;" x="40" y="125" width="20.416666666666668" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 20px; height: 20px;">J</span></foreignObject><foreignObject style="overflow: visible;" x="60.41666666666667" y="125" width="20.416666666666668" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 20px; height: 20px;">F</span></foreignObject><foreignObject style="overflow: visible;" x="80.83333333333334" y="125" width="20.416666666666664" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 20px; height: 20px;">M</span></foreignObject><foreignObject style="overflow: visible;" x="101.25" y="125" width="20.41666666666667" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 20px; height: 20px;">A</span></foreignObject><foreignObject style="overflow: visible;" x="121.66666666666667" y="125" width="20.41666666666667" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 20px; height: 20px;">M</span></foreignObject><foreignObject style="overflow: visible;" x="142.08333333333334" y="125" width="20.416666666666657" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 20px; height: 20px;">J</span></foreignObject><foreignObject style="overflow: visible;" x="162.5" y="125" width="20.416666666666686" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 20px; height: 20px;">J</span></foreignObject><foreignObject style="overflow: visible;" x="182.91666666666669" y="125" width="20.416666666666657" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 20px; height: 20px;">A</span></foreignObject><foreignObject style="overflow: visible;" x="203.33333333333334" y="125" width="20.416666666666657" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 20px; height: 20px;">S</span></foreignObject><foreignObject style="overflow: visible;" x="223.75" y="125" width="20.416666666666686" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 20px; height: 20px;">O</span></foreignObject><foreignObject style="overflow: visible;" x="244.16666666666669" y="125" width="20.416666666666657" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 20px; height: 20px;">N</span></foreignObject><foreignObject style="overflow: visible;" x="264.58333333333337" y="125" width="30" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 30px; height: 20px;">D</span></foreignObject><foreignObject style="overflow: visible;" y="96" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">0</span></foreignObject><foreignObject style="overflow: visible;" y="72" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">200</span></foreignObject><foreignObject style="overflow: visible;" y="48" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">400</span></foreignObject><foreignObject style="overflow: visible;" y="24" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">600</span></foreignObject><foreignObject style="overflow: visible;" y="0" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">800</span></foreignObject><foreignObject style="overflow: visible;" y="-30" x="0" height="30" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 30px; width: 30px;">1000</span></foreignObject></g></svg></div>                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Email Subscriptions</h4>
                            <p class="card-category">Last Campaign Performance</p>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <i class="material-icons">access_time</i> campaign sent 2 days ago
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-chart">
                        <div class="card-header card-header-danger">
                            <div class="ct-chart" id="completedTasksChart"><svg xmlns:ct="http://gionkunz.github.com/chartist-js/ct" width="100%" height="100%" class="ct-chart-line" style="width: 100%; height: 100%;"><g class="ct-grids"><line x1="40" x2="40" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="71.25" x2="71.25" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="102.5" x2="102.5" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="133.75" x2="133.75" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="165" x2="165" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="196.25" x2="196.25" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="227.5" x2="227.5" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line x1="258.75" x2="258.75" y1="0" y2="120" class="ct-grid ct-horizontal"></line><line y1="120" y2="120" x1="40" x2="290" class="ct-grid ct-vertical"></line><line y1="96" y2="96" x1="40" x2="290" class="ct-grid ct-vertical"></line><line y1="72" y2="72" x1="40" x2="290" class="ct-grid ct-vertical"></line><line y1="48" y2="48" x1="40" x2="290" class="ct-grid ct-vertical"></line><line y1="24" y2="24" x1="40" x2="290" class="ct-grid ct-vertical"></line><line y1="0" y2="0" x1="40" x2="290" class="ct-grid ct-vertical"></line></g><g><g class="ct-series ct-series-a"><path d="M40,92.4C71.25,30,71.25,30,71.25,30C102.5,66,102.5,66,102.5,66C133.75,84,133.75,84,133.75,84C165,86.4,165,86.4,165,86.4C196.25,91.2,196.25,91.2,196.25,91.2C227.5,96,227.5,96,227.5,96C258.75,97.2,258.75,97.2,258.75,97.2" class="ct-line"></path><line x1="40" y1="92.4" x2="40.01" y2="92.4" class="ct-point" ct:value="230" opacity="1"></line><line x1="71.25" y1="30" x2="71.26" y2="30" class="ct-point" ct:value="750" opacity="1"></line><line x1="102.5" y1="66" x2="102.51" y2="66" class="ct-point" ct:value="450" opacity="1"></line><line x1="133.75" y1="84" x2="133.76" y2="84" class="ct-point" ct:value="300" opacity="1"></line><line x1="165" y1="86.4" x2="165.01" y2="86.4" class="ct-point" ct:value="280" opacity="1"></line><line x1="196.25" y1="91.2" x2="196.26" y2="91.2" class="ct-point" ct:value="240" opacity="1"></line><line x1="227.5" y1="96" x2="227.51" y2="96" class="ct-point" ct:value="200" opacity="1"></line><line x1="258.75" y1="97.2" x2="258.76" y2="97.2" class="ct-point" ct:value="190" opacity="1"></line></g></g><g class="ct-labels"><foreignObject style="overflow: visible;" x="40" y="125" width="31.25" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 31px; height: 20px;">12p</span></foreignObject><foreignObject style="overflow: visible;" x="71.25" y="125" width="31.25" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 31px; height: 20px;">3p</span></foreignObject><foreignObject style="overflow: visible;" x="102.5" y="125" width="31.25" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 31px; height: 20px;">6p</span></foreignObject><foreignObject style="overflow: visible;" x="133.75" y="125" width="31.25" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 31px; height: 20px;">9p</span></foreignObject><foreignObject style="overflow: visible;" x="165" y="125" width="31.25" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 31px; height: 20px;">12p</span></foreignObject><foreignObject style="overflow: visible;" x="196.25" y="125" width="31.25" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 31px; height: 20px;">3a</span></foreignObject><foreignObject style="overflow: visible;" x="227.5" y="125" width="31.25" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 31px; height: 20px;">6a</span></foreignObject><foreignObject style="overflow: visible;" x="258.75" y="125" width="31.25" height="20"><span class="ct-label ct-horizontal ct-end" xmlns="http://www.w3.org/2000/xmlns/" style="width: 31px; height: 20px;">9a</span></foreignObject><foreignObject style="overflow: visible;" y="96" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">0</span></foreignObject><foreignObject style="overflow: visible;" y="72" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">200</span></foreignObject><foreignObject style="overflow: visible;" y="48" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">400</span></foreignObject><foreignObject style="overflow: visible;" y="24" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">600</span></foreignObject><foreignObject style="overflow: visible;" y="0" x="0" height="24" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 24px; width: 30px;">800</span></foreignObject><foreignObject style="overflow: visible;" y="-30" x="0" height="30" width="30"><span class="ct-label ct-vertical ct-start" xmlns="http://www.w3.org/2000/xmlns/" style="height: 30px; width: 30px;">1000</span></foreignObject></g></svg></div>                        </div>
                        <div class="card-body">
                        <h4 class="card-title">Completed Tasks</h4>
                        <p class="card-category">Last Campaign Performance</p>
                        </div>
                        <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">access_time</i> campaign sent 2 days ago
                        </div>
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

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h3>Referidos</h3>
                            <p>Total de referidos: <b><?= $totalReferidos ?></b></p>
                            <p>Referidos activos: <b><?= $totalReferidosDistribuidores ?></b></p>

                            <h3>📊 Compras de mis referidos</h3>

                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Fecha</th>
                                        <th>No. Factura</th>
                                        <th>Valor</th>
                                        <th>Comisión 5%</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php if (empty($referrals)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No hay compras aún</td>
                                    </tr>
                                <?php endif; ?>

                                <?php 
                                $total = 0;
                                foreach ($referrals as $row): $total = $total + $row['comision']; ?>
                                    <tr>
                                        <td><?= Html::encode($row['referido']) ?></td>
                                        <td><?= date('Y-m-d', strtotime($row['fecha'])) ?></td>
                                        <td>#<?= $row['invoice_id'] ?></td>
                                        <td>$<?= number_format($row['valor'], 2) ?></td>
                                        <td class="text-right">
                                            <span class="text-success">
                                                $<?= number_format($row['comision'], 2) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                    <tr>
                                        <td colspan="5" class="text-right"><b>Total: <?= number_format($total, 2)  ?></b></td>
                                    </tr>

                                </tbody>
                            </table>
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


<script>
document.addEventListener("DOMContentLoaded", function () {

    new Chartist.Line('#websiteViewsChart', {
        labels: ['M', 'T', 'W', 'T', 'F', 'S', 'S'],
        series: [
            [120, 150, 180, 170, 200, 230, 250]
        ]
    }, {
        low: 0,
        showArea: true,
        fullWidth: true,
        chartPadding: {
            right: 40
        }
    });

});
</script>















