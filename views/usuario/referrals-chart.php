<?php
$this->registerCssFile('https://balkan.app/js/OrgChart.css');
$this->registerJsFile('https://balkan.app/js/OrgChart.js', [
    'position' => \yii\web\View::POS_HEAD
]);


?>


<div id="tree"></div>

<script>
var nodes = <?= $data ?>;

var chart = new OrgChart(document.getElementById("tree"), {
    nodes: nodes,
    nodeBinding: {
        field_0: "name",
        field_1: "title"
    }
});
</script>

<style>
#tree {
    width: 100%;
    height: 700px;
}
</style>
