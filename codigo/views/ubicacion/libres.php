<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Revisar Ubicaciones';
$this->registerCssFile('@web/css/crud.css?v=' . time());
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="button-container-group">
    <?= Html::a('Todas', ['libres', 'toggle' => 'todas'], ['class' => 'btn btn-custom button-filter' . (in_array('todas', $currentFilters) ? ' active' : '')]) ?>
    <?= Html::a('Libres', ['libres', 'toggle' => 'libres'], ['class' => 'btn btn-custom button-filter' . (in_array('libres', $currentFilters) ? ' active' : '')]) ?>
    <?= Html::a('Nuevas', ['libres', 'toggle' => 'nueva'], ['class' => 'btn btn-custom button-filter' . (in_array('nueva', $currentFilters) ? ' active' : '')]) ?>
    <?= Html::a('Revisadas', ['libres', 'toggle' => 'revisada'], ['class' => 'btn btn-custom button-filter' . (in_array('revisada', $currentFilters) ? ' active' : '')]) ?>
    <?= Html::a('No Revisadas', ['libres', 'toggle' => 'no_revisada'], ['class' => 'btn btn-custom button-filter' . (in_array('no_revisada', $currentFilters) ? ' active' : '')]) ?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'pager' => [
        'firstPageLabel' => '<',
        'lastPageLabel'  => '>',
        'prevPageLabel'  => false,
        'nextPageLabel'  => false,
        'maxButtonCount' => 5,
        'options' => ['class' => 'pagination pagination-sm'],
    ],
    'summary' => "<div class='grid-summary'>{begin} - {end} de {totalCount}</div>",
    'columns' => [
        [
            'attribute' => 'id',
            'label' => 'ID',
            'enableSorting' => true,
        ],
        [
            'attribute' => 'nombre',
            'label' => 'Nombre',
            'enableSorting' => true,
        ],
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
                    5 => 'Ciudad',
                    6 => 'Localidad',
                    7 => 'Barrio/Zona'
                ];
                return $tipos[$model->ub_code] ?? 'Desconocido';
            },
            'enableSorting' => true,
        ],
        [
            'header' => 'Acciones',
            'class' => 'yii\grid\ActionColumn',
            'contentOptions' => ['class' => 'text-center'],
            'headerOptions' => ['class' => 'text-center'],
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-custom', 'title' => 'Ver']);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-pencil-alt"></i>', $url, ['class' => 'btn btn-custom', 'title' => 'Editar']);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash"></i>', $url, [
                        'class' => 'btn btn-custom',
                        'title' => 'Eliminar',
                        'data-confirm' => '¿Seguro que quieres eliminar esta ubicación? Si contiene ubicaciones hijas estas se eliminarán también',
                        'data-method' => 'post',
                    ]);
                },
            ],
            'template' => '{view} {update} {delete}',
        ],
    ],
]); ?>