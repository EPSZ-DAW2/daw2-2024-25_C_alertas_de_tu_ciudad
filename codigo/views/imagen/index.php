<?php

use app\models\Imagen;
use app\models\Usuario;
use app\models\Alerta;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\ImagenSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Mantenimiento de Imágenes';
$this->registerCss("
    h1 {
        text-align: center;
        margin: 50px;
    }
    .btn-success {
        background-color: #ea590a;
        border-color: #ea590a;
        width: 200px;
    }
    .btn-success:hover {
        background-color: #d65b08;
        border-color: #d65b08;
    }
    .button-container {
        text-align: center;
        margin-bottom: 20px;
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
        display: inline-block;
        padding: 8px 16px;
        font-size: 14px;
        background-color: #ea590a; /* Color de fondo */
        color: #fff; /* Color del texto */
        border-radius: 4px;
        border: 1px solid #ea590a; /* Borde del botón */
        text-decoration: none;
        transition: background-color 0.3s, color 0.3s;
    }

    .pagination li a:hover,
    .pagination li span:hover {
        background-color: #d65b08; /* Color de fondo cuando el usuario pasa el mouse */
        color: #fff; /* Color del texto al pasar el mouse */
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

    .btn-custom {
        background-color: #ea590a;
        color: white;
        margin-right: 10px;
        padding: 6px 12px;
        border-radius: 5px;
        text-align: center;
    }

    .btn-custom:hover {
        background-color: #d14e07;
        color: white;
    }
");

?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

<div class="imagen-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="button-container">
        <?= Html::a('Subir Imagen', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
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
                'attribute' => 'usuario_id',
                'label' => 'Usuario',
                'value' => function($model) {
                    return $model->usuario->username;
                },
            ],
            [
                'attribute' => 'alerta_id',
                'label' => 'Alerta',
                'value' => function($model) {
                    return $model->alerta->titulo;
                },
            ],
            [
                'header' => 'Acciones',
                'class' => ActionColumn::className(),
                'contentOptions' => ['class' => 'text-center'],
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-eye"></i>', $url, [
                            'class' => 'btn btn-custom',
                            'title' => 'Ver',
                        ]);
                    },
                    'update' => function ($url, $model, $key) {
                        return Html::a('<i class="fas fa-pencil-alt"></i>', $url, [
                            'class' => 'btn btn-custom',
                            'title' => 'Editar',
                        ]);
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

</div>
