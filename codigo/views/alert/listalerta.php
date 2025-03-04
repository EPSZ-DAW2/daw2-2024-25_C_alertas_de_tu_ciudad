<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Mis Alertas';
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="alertas-index">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'], // 序号列

            'id', // 警报 ID
            'titulo', // 警报标题
            'descripcion', // 警报描述
            'fecha_creacion', // 创建时间
            'fecha_expiracion', // 过期时间
            [
                'attribute' => 'estado',
                'value' => function ($model) {
                    return $model->estado === 'pendiente' ? 'Pendiente' : 'Completado';
                },
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{modificar}', // 只显示修改按钮
                'buttons' => [
                    'modificar' => function ($url, $model) {
                        return Html::a('Modificar', ['modificar', 'id' => $model->id], [
                            'class' => 'btn btn-primary btn-sm',
                        ]);
                    },
                ],
            ],
        ],
    ]) ?>
</div>
