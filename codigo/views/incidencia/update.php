<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = 'Editar Incidencia';
?>

<div class="incidencias-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'estado')->dropDownList(['nueva' => 'Nueva', 'en proceso' => 'En Proceso', 'resuelta' => 'Resuelta']) ?>

    <?= Html::submitButton('Guardar', ['class' => 'btn btn-primary']) ?>

    <?php ActiveForm::end(); ?>
</div>
