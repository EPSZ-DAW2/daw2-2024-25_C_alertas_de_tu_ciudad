<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Responder Incidencia';
?>
<div class="incidencia-responder">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="incidencia-form">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'descripcion')->textarea(['readonly' => true]) ?>
        <?= $form->field($model, 'respuesta')->textarea(['rows' => 6]) ?>
        <?= $form->field($model, 'estado')->dropDownList([
            'revisada' => 'Revisada',
            'no revisada' => 'No Revisada',
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Guardar Respuesta', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>
