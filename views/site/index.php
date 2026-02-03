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

        <?php if( $idRole == 5 || $idRole == 1 || $idRole == 2): ?>
        
        <div class="row">
            <!-- Card for Licencias Vencidas -->
            <div class="col-lg-6 col-md-12 col-sm-12">

                <div class="card card-stats">
                    <div class="card-header card-header-icon card-header-warning">
                        <div class="card-icon">
                            <i class="material-icons">perm_contact_calendar</i>
                        </div>
                        <p class="card-category">Licencias</p>
                        <h4 class="card-title">Vencidas<small>10 días</small></h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <tr>
                                <th class="text-center">
                                    Conductor
                                </th>

                                <th class="text-center">
                                    Categoría
                                </th>
                                <th class="text-center">
                                    Fecha Vencimiento
                                </th>
                                <th class="text-center">
                                    Días Restantes
                                </th>
                            </tr>
                            <?php foreach ($licencias as $licencia): ?>
                            <tr>
                                <td class="text-center">
                                    <?php $conductor = $licencia['conductor'] ?>
                                    <?= Html::a($conductor, ['conductor/view', 'id' => $licencia['id'], '#' => 'conductorlicencias'], ['class' => '']) ?>

                                </td>
                                <td class="text-center">
                                    <?= $licencia['category'] ?>
                                </td>
                                <td class="text-center">
                                    <?= $licencia['fecha_vencimiento'] ?>
                                </td>
                                <td class="text-center <?= ($licencia['dias_restantes'] < 0) ? 'text-danger' : '' ?>">
                                    <?= $licencia['dias_restantes'] ?>
                                </td>

                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="stats">
                            <i class="material-icons text-danger">warning</i>
                            <a href="#">...</a>
                        </div>
                    </div>
                </div>            
            </div>
        </div>
        <?php endif; ?>

        <?php if( $idRole == 7 || $idRole == 1 || $idRole == 2): ?>
        <div class="row">
            <!-- Card for Docs Vencidas -->
            <div class="col-lg-7 col-md-7 col-sm-12">

                <div class="card card-stats">
                    <div class="card-header card-header-icon card-header-info">
                        <div class="card-icon">
                            <i class="material-icons">directions_bus</i>
                        </div>
                        <h2 class="card-category">Documentos</h2>
                        <h4 class="card-title">Vencidos<small>10 días</small></h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <tr>
                                <th class="text-center">
                                    Vehículo
                                </th>
                                <th class="text-center">
                                    Documento
                                </th>
                                <th class="text-center">
                                    Fecha Vencimiento
                                </th>
                                <th class="text-center">
                                    Días Restantes
                                </th>
                            </tr>
                            <?php foreach ($documentos as $doc): ?>
                            <tr>
                                <td class="text-center">
                                    <?php $vehicle = $doc['vehiculo'] ?>
                                    <?= Html::a($vehicle, ['vehicle/view', 'id' => $doc['id']], ['class' => '']) ?>

                                </td>
                                <td class="text-center">
                                    <?= $doc['tipo_documento'] ?>
                                </td>
                                <td class="text-center">
                                    <?= $doc['fecha_vencimiento'] ?>
                                </td>
                                <td class="text-center <?= ($doc['dias_restantes'] < 0) ? 'text-danger' : '' ?>">
                                    <?= $doc['dias_restantes'] ?>
                                </td>

                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="stats">
                            <i class="material-icons text-danger">warning</i>
                            <a href="#">...</a>
                        </div>
                    </div>
                </div>            

                
            </div>
        </div>
        <?php endif; ?>


        <?php if( $idRole == 6): //Operativo ?>

        
            <!-- Operaciones EXTERNAS -->
            <div class="row">
                
                <div class="col-lg-12">
                    <h2>Operaciones Externas</h2>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body dashboard-operacion">
                            <?= Html::a('Ver Todas las Solicitudes', ['operacionsolicitud/indexall'], ['class' => 'btn btn-primary']) ?>
                            
                            <?= $this->render('../operacionsolicitud/indexall', [
                                'dataProvider' => $solicitudes,
                                'searchModel' => $searchModelSolicitudOperacion,
                            ]) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body dashboard-operacion">
                            <?= Html::a('Ver Todas las Operaciones', ['operacion/externasaprobadas'], ['class' => 'btn btn-primary']) ?>
                            <?= $this->render('../operacion/externasaprobadas', [
                                'dataProvider' => $operacionesAprobadasExternas,
                                'searchModel' => $searchModelOperaciones,
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 card"> 
                    <div class="card-body dashboard-operacion">
                        <?= Html::a('Ver Todas las Operaciones', ['operacion/indexexternaejecutada'], ['class' => 'btn btn-primary']) ?>
                        <?= $this->render('../operacion/indexexternaejecutada', [
                                'dataProvider' => $operacionesExternasEjecutada,
                                'searchModel' => $searchModelOperaciones,
                            ]) ?>

                    </div>
                </div>
                
            </div>
            <hr>
            <!-- Operaciones INTERNAS -->
            <div class="row">
                <div class="col-lg-12">
                    <h2>Operaciones Internas</h2>
                </div>
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body dashboard-operacion">
                            <?= Html::a('Ver Todas las Solicitudes', ['operacionsolicitud/indexallinternas'], ['class' => 'btn btn-primary']) ?>
                            
                            <?= $this->render('../operacionsolicitud/indexallinternas', [
                                'dataProvider' => $operacionesGeneradas,
                                'searchModel' => $searchModelSolicitudOperacion,
                            ]) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body dashboard-operacion">
                            <?= Html::a('Ver Todas las Operaciones', ['operacion/internasaprobadas'], ['class' => 'btn btn-primary']) ?>
                            <?= $this->render('../operacion/internasaprobadas', [
                                'dataProvider' => $operacionesAprobadas,
                                'searchModel' => $searchModelOperaciones,
                            ]) ?>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12 card"> 
                    <div class="card-body dashboard-operacion">
                        <?= Html::a('Ver Todas las Operaciones', ['operacion/internasejecutadas'], ['class' => 'btn btn-primary']) ?>
                        <?= $this->render('../operacion/internasejecutadas', [
                                'dataProvider' => $operacionesEjecutadas,
                                'searchModel' => $searchModelOperaciones,
                            ]) ?>

                    </div>
                </div>
                
            </div>

        <?php endif; ?>


        <?php if( $idRole == 9): //Prestacion ?>
            <!-- Operaciones EXTERNAS -->
            <div class="row">
                
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body dashboard-operacion">
                            <?= Html::a('Ver Todas las Solicitudes', ['operacionsolicitud/index'], ['class' => 'btn btn-primary']) ?>
                            
                            <?= $this->render('../operacionsolicitud/index', [
                                'dataProvider' => $solicitudes,
                                'searchModel' => $searchModelSolicitudOperacion,
                            ]) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body dashboard-operacion">
                            <?= Html::a('Ver Todas las Operaciones', ['operacion/externasaprobadas'], ['class' => 'btn btn-primary']) ?>
                            <?= $this->render('../operacion/externasaprobadas', [
                                'dataProvider' => $operacionesExternasAprobadas,
                                'searchModel' => $searchModelOperaciones,
                            ]) ?>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12 card"> 
                    <div class="card-body dashboard-operacion">
                        <?= Html::a('Ver Todas las Operaciones', ['operacion/indexexternaejecutada'], ['class' => 'btn btn-primary']) ?>
                        <?= $this->render('../operacion/indexexternaejecutada', [
                                'dataProvider' => $operacionesExternasEjecutadas,
                                'searchModel' => $searchModelOperaciones,
                            ]) ?>

                    </div>
                </div>
                
            </div>
        <?php endif; ?>











        <div class="row">
            <!-- <div class="col-lg-3 col-md-3 col-sm-12">
                <?php Card::begin([
                    'header'=>'header-icon',
                    'type'=>'card-stats',
                    'icon'=>'<i class="material-icons">store</i>',
                    'color'=>'success',
                    'title'=>'$34,245',
                    'subtitle'=>'Revenue',
                    'footer'=>'<div class="stats">
                            <i class="material-icons">date_range</i> Last 24 Hours
                          </div>',
                ]); Card::end(); ?>
            </div> -->

<!--             
            <div class="col-lg-3 col-md-3 col-sm-12">
                <?php Card::begin([
                    'header'=>'header-icon',
                    'type'=>'card-stats',
                    'icon'=>'<i class="material-icons">info_outline</i>',
                    'color'=>'danger',
                    'title'=>'75',
                    'subtitle'=>'Fixed Issues',
                    'footer'=>'<div class="stats">
                            <i class="material-icons">local_offer</i> Tracked from Github
                          </div>',
                ]); Card::end(); ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <?php Card::begin([
                    'type'=>'card-stats',
                    'header'=>'header-icon',
                    'icon'=>'<i class="fa fa-twitter"></i>',
                    'color'=>'info',
                    'title'=>'+245',
                    'subtitle'=>'Followers',
                    'footer'=>'<div class="stats">
                            <i class="material-icons">update</i> Just Updated
                          </div>',
                ]); Card::end(); ?>
            </div> -->
        </div>

    </div>

</div>
