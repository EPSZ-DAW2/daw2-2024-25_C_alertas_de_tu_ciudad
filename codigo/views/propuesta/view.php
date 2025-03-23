<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PropuestaEtiqueta */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Gestión de Propuestas de Etiquetas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="propuesta-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            [
                'attribute' => 'descripcion',
                'format' => 'ntext',
            ],
            'usuario_id',
            'estado',
            'creado_en',
            'actualizado_en',
        ],
    ]) ?>

    <p>
        <?= Html::a('Aprobar', ['aprobar', 'id' => $model->id], [
            'class' => 'btn btn-success',
            'data' => [
                'confirm' => '¿Estás seguro de aprobar esta propuesta?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Rechazar', ['rechazar', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '¿Estás seguro de rechazar esta propuesta?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

</div>
