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
$this->registerCssFile('@web/css/crud.css?v=' . time());
?>

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
