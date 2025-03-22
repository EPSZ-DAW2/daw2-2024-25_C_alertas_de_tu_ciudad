<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Mantenimiento de Ubicaciones';
$this->registerCss("
    h1 {
        text-align: center;
        margin: 50px;
    }

    .btn-success, .btn-custom {
        background-color: #ea590a;
        border-color: #ea590a;
        color: white;
        padding: 6px 12px;
        border-radius: 5px;
        margin-right: 10px;
        text-align: center;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .btn-success:hover, .btn-success:active,
    .btn-custom:hover, .btn-custom:active {
        background-color: #d65b08;
        border-color: #d65b08;
    }

    .button-container-group {
        text-align: center;
    }

    .button-container {
        display: inline-block;
        margin: 0 10px 10px 0;
    }

    table thead th {
        color: #ea590a;
        text-align: center;
    }

    table thead th a {
        color: #ea590a;
        text-decoration: none;
        position: relative;
        padding-right: 30px;
    }

    table thead th a:after {
        content: '\\21C5';
        position: absolute;
        right: 5px;
        opacity: 0.5;
        transition: opacity 0.3s;
        font-size: 16px;
    }

    table thead th a.asc:after {
        content: '\\2191';
        opacity: 1;
        font-size: 18px;
    }

    table thead th a.desc:after {
        content: '\\2193';
        opacity: 1;
        font-size: 18px;
    }

    .grid-summary {
        text-align: right;
        font-weight: normal;
        color: #999;
        font-size: 13px;
    }

    .pagination {
        margin: 20px 0;
        justify-content: center;
    }

    .pagination li {
        margin: 0 5px;
    }

    .pagination li a,
    .pagination li span {
        padding: 8px 16px;
        font-size: 14px;
        background-color: #ea590a;
        color: #fff;
        border-radius: 4px;
        border: 1px solid #ea590a;
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
    }

    .pagination li a:hover,
    .pagination li span:hover {
        background-color: #d65b08;
    }

    .pagination .active a {
        background-color: #d65b08;
        border-color: #d65b08;
    }

    .pagination .disabled a,
    .pagination .disabled span {
        background-color: #f1f1f1;
        color: #ccc;
        cursor: not-allowed;
    }
");
?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
<h1><?= Html::encode($this->title) ?></h1>

<div class="button-container-group">
    <?= Html::a('Crear Ubicación', ['create'], ['class' => 'btn btn-custom button-container']) ?>
    <?= Html::a('Revisar Ubicaciones', ['view'], ['class' => 'btn btn-custom button-container']) ?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'pager' => [
         'firstPageLabel' => '<<',
         'lastPageLabel'  => '>>',
         'prevPageLabel'  => '<',
         'nextPageLabel'  => '>',
         'maxButtonCount' => 5,
         'options' => ['class' => 'pagination pagination-sm'],
    ],
    'summary' => "<div class='grid-summary'>{begin}-{end} de {totalCount}</div>",
    'columns' => [
        [
            'attribute' => 'id',
            'label' => 'ID',
        ],
        [
            'attribute' => 'nombre',
            'label' => 'Nombre',
        ],
        [
            'attribute' => 'ub_code_padre',
            'label' => 'Ubicación Padre',
            'value' => function($model) {
                return $model->ubCodePadre ? $model->ubCodePadre->nombre : '(Sin padre)';
            },
        ],
        [
            'header' => 'Acciones',
            'class' => 'yii\grid\ActionColumn',
            'contentOptions' => ['class' => 'text-center'],
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
                        'data-confirm' => '¿Estás seguro de que deseas eliminar este registro?',
                        'data-method' => 'post',
                    ]);
                },
            ],
            'template' => '{view} {update} {delete}',
        ],
    ],
]); ?>
