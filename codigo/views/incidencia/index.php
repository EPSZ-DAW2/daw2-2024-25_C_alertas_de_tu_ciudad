<?php
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Incidencias';
?>

<div class="incidencias-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Bienvenido a la página de Incidencias.</p>
    <?= Html::a('Crear Incidencia', ['create'], ['class' => 'btn btn-success']) ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'descripcion',
            [
                'attribute' => 'estado',
                'filter' => ['nueva' => 'Nueva', 'en proceso' => 'En Proceso', 'resuelta' => 'Resuelta'],
            ],
            'fecha_creacion',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]) ?>
</div>
