<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<div class="container mt-4">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput() ?>
    <?= $form->field($model, 'descripcion')->textarea() ?>
    <?= $form->field($model, 'fecha_inicio')->input('datetime-local') ?>
    <?= $form->field($model, 'duracion_estimada')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
