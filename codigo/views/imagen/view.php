<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Imagen $model */

$this->title = 'Imagen: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Imágenes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerCssFile('@web/css/crud.css?v=' . time());
?>

<div class="imagen-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="button-container-group">
        <?= Html::a('Actualizar Imagen', ['update', 'id' => $model->id], ['class' => 'btn btn-custom button-container']) ?>
        <?= Html::a('Eliminar Imagen', ['delete', 'id' => $model->id], ['class' => 'btn btn-custom button-container delete',
        'data' => [
                        'confirm' => '¿Seguro que quieres eliminar esta ubicación? Si contiene ubicaciones hijas estas se eliminarán también',
                        'method' => 'post',
                    ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            [
                'attribute' => 'usuario_id',
                'value' => $model->usuario ? $model->usuario->username : 'Ninguna',
            ],
            [
                'attribute' => 'alerta_id',
                'value' => $model->alerta ? $model->alerta->titulo : 'Ninguna',
            ],
            'tam_img',
            'metadatos:ntext',
            'created_at',
        ],
    ]) ?>

</div>
