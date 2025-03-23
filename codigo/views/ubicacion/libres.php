<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Revisar Ubicaciones';
$this->registerCssFile('@web/css/crud.css?v=' . time());
?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<h1><?= Html::encode($this->title) ?></h1>

<?= GridView::widget([
    'dataProvider' => new \yii\data\ArrayDataProvider([
        'allModels' => $ubicacionesLibres,
        'pagination' => ['pageSize' => 10],
    ]),
    'columns' => [
        'id',
        'nombre',
        [
            'attribute' => 'ub_code',
            'label' => 'Tipo',
            'value' => function($model) {
                $tipos = [
                    0 => 'Planeta',
                    1 => 'Continente',
                    2 => 'País',
                    3 => 'Comunidad Autónoma',
                    4 => 'Provincia',
                    6 => 'Localidad',
                    7 => 'Barrio/Zona'
                ];
                return $tipos[$model->ub_code] ?? 'Desconocido';
            }
        ],
        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
