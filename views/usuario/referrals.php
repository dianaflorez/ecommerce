

<?php

use yii\helpers\Html;
use yii\grid\GridView;
use kongoon\orgchart\OrgChart;


/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis Referidos';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="cliente-uninivel-index">

    <h2><?= Html::encode($this->title) ?></h2>

    <?php

    echo
    OrgChart::widget([
        'data' =>
        $out
    ]);
    ?>
</div>
