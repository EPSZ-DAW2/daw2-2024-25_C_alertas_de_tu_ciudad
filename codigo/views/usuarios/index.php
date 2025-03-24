<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Gestión de Usuarios';
?>

<div class="usuario-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Filtro -->
    <div class="filter-form">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => ['index'],
        ]); ?>

        <?= $form->field($searchModel, 'username')->textInput(['placeholder' => 'Nombre de Usuario']) ?>
        <?= $form->field($searchModel, 'email')->textInput(['placeholder' => 'Correo Electrónico']) ?>
        <?= $form->field($searchModel, 'fecha_inicio')->input('date') ?>
        <?= $form->field($searchModel, 'fecha_fin')->input('date') ?>

        <div class="form-group">
            <?= Html::submitButton('Buscar', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <!-- Tabla -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            'email',
            'estado_revisar',
            'respuesta', // 添加此行显示 respuesta 字段
            'eliminar_razon',
            
           
            [
                'attribute' => 'role',
                'label' => 'Rol',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::beginForm(['usuarios/update-role', 'id' => $model->id], 'post') .
                        Html::dropDownList(
                            'role', 
                            $model->role, 
                            [
                                'normal' => 'Usuario',
                                'moderator' => 'Moderator',
                                'admin' => 'Admin',
                                'sysadmin' => 'Sysadmin'
                            ],
                            ['class' => 'form-control', 'style' => 'width:120px; display:inline-block;']
                        ) . ' ' .
                        Html::submitButton('Modificar', ['class' => 'btn btn-primary btn-sm', 'style' => 'margin-left:5px;']) .
                        Html::endForm();
                },
            ],
            
            
            
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {lock} {revisar} {responder}',
                'buttons' => [
                    
                    'lock' => function ($url, $model, $key) {
                        if ($model->is_locked) {
                            return Html::a('Desbloquear', ['unlock', 'id' => $model->id], [
                                'class' => 'btn btn-success btn-sm',
                                'data' => [
                                    'confirm' => '¿Estás seguro de desbloquear este usuario?',
                                    'method' => 'post',
                                ],
                            ]);
                        } else {
                            return Html::a('Bloquear', ['lock', 'id' => $model->id], [
                                'class' => 'btn btn-danger btn-sm',
                                'data' => [
                                    'confirm' => '¿Estás seguro de bloquear este usuario?',
                                    'method' => 'post',
                                ],
                            ]);
                        }
                    },
                    'revisar' => function ($url, $model, $key) {
                    return Html::a('Revisar', ['revisar', 'id' => $model->id], [
                        'class' => 'btn btn-warning btn-sm',
                        'data' => [
                            'confirm' => '¿Estás seguro de marcar esta usuario como revisada?',
                            'method' => 'post',
                        ],
                    ]);
                },
                'responder' => function ($url, $model, $key) {
                    return Html::a('Responder', ['responder', 'id' => $model->id], [
                        'class' => 'btn btn-info btn-sm text-white',
                        'style' => 'margin-left: 1px;', // 添加间距
                    ]);
                },
                ],
            ],
        ],
    ]); ?>



    
</div>

