<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Ubicaciones Libres';
?>

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
                    1 => 'Continente',
                    2 => 'País',
                    3 => 'Región',
                    4 => 'Provincia',
                    6 => 'Ciudad',
                    7 => 'Distrito/Zona'
                ];
                return $tipos[$model->ub_code] ?? 'Desconocido';
            }
        ],
        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
