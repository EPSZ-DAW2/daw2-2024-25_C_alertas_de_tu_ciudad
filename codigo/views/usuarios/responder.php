<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Responder Usuario';
?>

<div class="usuario-responder">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'respuesta')->textarea(['rows' => 4]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar Respuesta', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
