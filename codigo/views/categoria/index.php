<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Gestión de Categorías';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= Html::a('Crear Categoría', ['create'], ['class' => 'btn btn-success']) ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'nombre',
            'descripcion',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>