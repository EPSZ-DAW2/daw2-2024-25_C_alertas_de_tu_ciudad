<?php
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Notificaciones';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="notificacion-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'usuario_id',
            'mensaje:ntext',
            'fecha',
           
        ],
    ]); ?>
</div>
