<?php
use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $propuestas array */
?>
<div class="mis-propuestas">
    <h2>Mis Propuestas</h2>
    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'allModels' => $propuestas,
        ]),
        'columns' => [
            'id',
            'nombre',
            'descripcion',
            'estado',
        ],
    ]); ?>
</div>
