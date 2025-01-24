<?php
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Revisar / Responder Incidencias';
?>

<div class="incidencias-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- 过滤表单 -->
    <div class="filter-form">
        <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => ['index'],
        ]); ?>

        <?= $form->field($searchModel, 'fecha_inicio')->input('date') ?>
        <?= $form->field($searchModel, 'fecha_fin')->input('date') ?>
        <?= $form->field($searchModel, 'estado')->dropDownList([
            '' => 'Todas',
            'no revisada' => 'No revisadas',
            'revisada' => 'Revisadas',
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Filtrar', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

    <!-- 数据表格 -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'descripcion',
            'estado',
            'fecha_creacion',
            'fecha_revision',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {revisar} {responder}', // 将 {delete} 替换为 {revisar}
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('Editar', ['update', 'id' => $model->id], [
                            'class' => 'btn btn-primary btn-sm',
                        ]);
                    },
                    'revisar' => function ($url, $model, $key) {
                        return Html::a('Revisar', ['revisar', 'id' => $model->id], [
                            'class' => 'btn btn-warning btn-sm',
                            'data' => [
                                'confirm' => '¿Estás seguro de marcar esta incidencia como revisada?',
                                'method' => 'post',
                            ],
                        ]);
                    },
                    'responder' => function ($url, $model, $key) {
    return Html::a('Responder', ['responder', 'id' => $model->id], [
        'class' => 'btn btn-success btn-sm',
    ]);
},
                ],
            ],
        ],
    ]); ?>
</div>
