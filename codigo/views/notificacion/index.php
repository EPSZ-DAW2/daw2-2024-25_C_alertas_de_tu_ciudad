<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

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
            [
                'attribute' => 'Acciones',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(
                        'Eliminar',
                        ['notificacion/delete', 'id' => $model->id],
                        [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => '¿Estás seguro de que deseas eliminar esta notificación?',
                                'method' => 'post',
                            ],
                        ]
                    );
                },
            ],
        ],
    ]); ?>
</div>
