<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Editar Incidencia';
?>

<div class="incidencia-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="incidencia-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'descripcion')->textarea(['rows' => 4]) ?>

        <?= $form->field($model, 'estado')->dropDownList([
            'nueva' => 'Nueva',
            'revisada' => 'Revisada',
            'no revisada' => 'No Revisada',
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
