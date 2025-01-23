<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = 'Gestión de Usuarios';

?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="usuarios-search">
    <?php $form = ActiveForm::begin([
        'method' => 'get',
    ]); ?>

    <?= $form->field($searchModel, 'username') ?>
    <?= $form->field($searchModel, 'email') ?>
    <?= $form->field($searchModel, 'fecha_inicio')->input('date') ?>
    <?= $form->field($searchModel, 'fecha_fin')->input('date') ?>

    <div class="form-group">
        <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        'id',
        'username',
        'email',
        'is_locked:boolean', // 显示是否锁定的字段
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete} {lock}', // 定义 "Bloquear" 按钮
            'buttons' => [
                'lock' => function ($url, $model, $key) {
                    if (!$model->is_locked) {
                        return \yii\helpers\Html::a(
                            'Bloquear',
                            ['usuarios/lock', 'id' => $model->id], // 确保URL正确，指向控制器的actionLock
                            [
                                'class' => 'btn btn-danger btn-sm',
                                'data-confirm' => '¿Estás seguro de bloquear a este usuario?',
                                'data-method' => 'post', // 使用POST方法提交请求
                            ]
                        );
                    } else {
                        return \yii\helpers\Html::a(
                            'Desbloquear',
                            ['usuarios/unlock', 'id' => $model->id], // 解锁的URL
                            [
                                'class' => 'btn btn-success btn-sm',
                                'data-confirm' => '¿Estás seguro de desbloquear a este usuario?',
                                'data-method' => 'post',
                            ]
                        );
                    }
                },
            ],
        ],
    ],
]); ?>


