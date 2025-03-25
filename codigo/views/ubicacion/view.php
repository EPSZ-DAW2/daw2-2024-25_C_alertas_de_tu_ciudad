<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Ubicacion $model */

$this->title = 'Ubicación: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Ubicaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$this->registerCssFile('@web/css/crud.css?v=' . time());
?>

<div class="ubicacion-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="button-container-group">
        <?= Html::a('Actualizar Ubicación', ['update', 'id' => $model->id], ['class' => 'btn btn-custom button-container']) ?>
        <?= Html::a('Eliminar Ubicación', ['delete', 'id' => $model->id], ['class' => 'btn btn-custom button-container delete',
        'data' => [
                        'confirm' => '¿Seguro que quieres eliminar esta ubicación? Si contiene ubicaciones hijas estas se eliminarán también',
                        'method' => 'post',
                    ],
        ]) ?>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'ub_code',
            'nombre',
            'code_iso',
            [
                'attribute' => 'ub_code_padre',
                'value' => $model->ubCodePadre ? $model->ubCodePadre->nombre : 'Ninguna',
            ],
            'latitud',
            'longitud',
            'fecha_creacion',
            [
                'attribute' => 'is_revisada',
                'value' => $model->is_revisada ? 'Sí' : 'No',
            ],
        ],
    ]) ?>

</div>
