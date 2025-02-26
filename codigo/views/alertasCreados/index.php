<?php
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Alertas Creadas';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="alertasCreados-index">
    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
          

            'ID',                // ID 列
            'Titulo',            // 标题列
            'Descripcion:ntext', // 描述列，格式为多行文本
            'Fecha_de_Vencimiento',  // 到期日期列
            [
                'attribute' => 'Acciones',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a(
                        'Eliminar',
                        ['alertascreados/delete', 'id' => $model->ID],
                        [
                            'class' => 'btn btn-danger btn-sm',
                            'data' => [
                                'confirm' => '¿Estás seguro de que deseas eliminar esta alerta?',
                                'method' => 'post',
                            ],
                        ]
                    );
                },
            ],



            

     /**
     * 
     * 
     * 
     * 
     * [    'class' => 'yii\grid\ActionColumn',  // 默认操作列（查看、更新、删除）  ],
     * 
     */ 
        ],
    ]); ?>
</div>
