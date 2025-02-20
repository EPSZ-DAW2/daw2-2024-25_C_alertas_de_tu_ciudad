<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Crear Incidencia';
?>

<div class="incidencias-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>
</div>
