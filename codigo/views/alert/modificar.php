<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ModificarAlertas */

$this->title = 'Modificar Alerta: ' . $model->titulo;
?>
<h1><?= Html::encode($this->title) ?></h1>

<div class="alertas-modificar">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'descripcion')->textarea(['rows' => 4]) ?>
    <?= $form->field($model, 'fecha_expiracion')->textInput(['type' => 'datetime-local']) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar Cambios', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
