<?php
use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Gestión de Propuestas de Etiquetas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="propuesta-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'nombre',
            [
                'attribute' => 'descripcion',
                'format' => 'ntext',
            ],
            'usuario_id',
            'estado',
            'creado_en',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {aprobar} {rechazar}',
                'buttons' => [
                    'aprobar' => function ($url, $model, $key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-ok"></span>',
                            ['aprobar', 'id' => $model->id],
                            [
                                'title' => 'Aprobar',
                                'data-confirm' => '¿Estás seguro de aprobar esta propuesta?',
                                'data-method' => 'post',
                            ]
                        );
                    },
                    'rechazar' => function ($url, $model, $key) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-remove"></span>',
                            ['rechazar', 'id' => $model->id],
                            [
                                'title' => 'Rechazar',
                                'data-confirm' => '¿Estás seguro de rechazar esta propuesta?',
                                'data-method' => 'post',
                            ]
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
