<?php
use yii\widgets\DetailView;

$this->title = 'Detalles de Incidencia';
?>

<div class="incidencias-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'descripcion',
            'estado',
            'creado_por',
            'fecha_creacion',
            'fecha_revision',
        ],
    ]) ?>
</div>
