<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Ubicacion;

/* @var $this yii\web\View */
/* @var $model app\models\Ubicacion */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile('@web/css/crud.css?v=' . time());
?>

<div class="ubicacion-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true])->label('Nombre de la ubicación') ?>

    <?= $form->field($model, 'ub_code')->dropDownList([
            1 => 'Continente',
            2 => 'País',
            3 => 'Región',
            4 => 'Provincia',
            6 => 'Ciudad',
            7 => 'Distrito/Zona'
        ], ['prompt' => 'Seleccione el tipo de ubicación'])->label(false) ?>

    <?= $form->field($model, 'ub_code_padre')->dropDownList(
            ArrayHelper::map(Ubicacion::find()->all(), 'id', 'nombre'),
            ['prompt' => 'Seleccione una ubicación padre']
        )->label(false) ?>

    <?= $form->field($model, 'code_iso')->textInput(['maxlength' => true])->label('Código ISO') ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

