<?php
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Gestión de Etiquetas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="etiqueta-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Crear Etiqueta', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'nombre',
            'descripcion',
            'creado_en',
            'actualizado_en',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>