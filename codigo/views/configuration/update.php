<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;


$this->title = 'Actualizar Configuración: ' . $model->key_name;
?>

<h1><?= Html::encode($this->title) ?></h1>

<div class="configuration-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'value')->textarea(['rows' => 4]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
