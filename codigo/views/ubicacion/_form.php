<?php
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Ubicacion;

/* @var $this yii\web\View */
/* @var $model app\models\Ubicacion */
/* @var $form yii\widgets\ActiveForm */

$this->registerCss("
    .ubicacion-form {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .form-group {
        margin-bottom: 20px;
    }
    .btn-success {
        background-color: #ea590a;
        border-color: #ea590a;
        width: 100%;
        padding: 12px;
        font-size: 16px;
        border-radius: 5px;
    }
    .btn-success:hover {
        background-color: #d65b08;
        border-color: #d65b08;
    }
    .form-control {
        font-size: 16px;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        width: 100%;
    }
    .form-control:focus {
        border-color: #ea590a;
        box-shadow: 0 0 5px rgba(234, 89, 10, 0.5);
    }
    .select2-container--default .select2-selection--single {
        height: 38px;
        padding: 6px;
        border-radius: 5px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        font-size: 16px;
    }
");
?>

<div class="ubicacion-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ub_code')->dropDownList([
        1 => 'Continente',
        2 => 'País',
        3 => 'Región',
        4 => 'Provincia',
        6 => 'Ciudad',
        7 => 'Distrito/Zona'
    ], ['prompt' => 'Seleccione el tipo de ubicación']) ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'code_iso')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'ub_code_padre')->dropDownList(
        ArrayHelper::map(Ubicacion::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Seleccione una ubicación padre']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
