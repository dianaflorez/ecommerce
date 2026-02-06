<?php
use kongoon\orgchart\OrgChart;

/** @var array $data */
?>

<div class="orgchart-wrapper">
    <?= OrgChart::widget([
        'data' => $data,
        'nodeTemplate' => '
            <div class="node">
                <strong>{name}</strong>
            </div>
        ',
        'options' => [
            'pan' => true,    // permite arrastrar
            'zoom' => true,   // permite zoom
        ],
    ]); ?>
</div>
