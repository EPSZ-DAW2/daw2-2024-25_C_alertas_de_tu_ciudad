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
        'dataProvider' => $dataProvider,  // 确保控制器提供了 $dataProvider
        'columns' => [
           

            'id',                // 通知 ID
            'usuario_id',        // 用户 ID
            'mensaje:ntext',     // 通知内容
            'fecha',             // 通知日期
            
            [
                'attribute' => 'Acciones',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(
                        'Eliminar',
                        ['notificacion/delete', 'id' => $model->id],  // 删除请求
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
