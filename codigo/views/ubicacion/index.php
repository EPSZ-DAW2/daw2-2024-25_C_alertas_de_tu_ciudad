<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Mantenimiento de Ubicaciones';
$this->registerCssFile('@web/css/crud.css?v=' . time());
?>
<h1><?= Html::encode($this->title) ?></h1>
<div class="button-container-group">
    <?= Html::a('Crear Ubicación', ['create'], ['class' => 'btn btn-custom button-container']) ?>
    <?= Html::a('Revisar Ubicaciones', ['libres'], ['class' => 'btn btn-custom button-container']) ?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
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
            'attribute' => 'ub_code_padre',
            'label' => 'Ubicación Padre',
            'value' => function($model) {
                return $model->ubCodePadre ? $model->ubCodePadre->nombre : '(Sin padre)';
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

