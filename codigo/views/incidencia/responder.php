<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Responder Incidencia';
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="incidencia-responder">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'respuesta')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar Respuesta', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
