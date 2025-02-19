<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Etiqueta;

/** @var yii\web\View $this */
/** @var app\models\Categoria $model */
/** @var yii\widgets\ActiveForm $form */

// Obtener todas las etiquetas disponibles
$etiquetas = ArrayHelper::map(Etiqueta::find()->all(), 'id', 'nombre');
?>

<div class="categoria-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'id_padre')->dropDownList(
        ArrayHelper::map(app\models\Categoria::find()->all(), 'id', 'nombre'),
        ['prompt' => 'Seleccione una categoría padre']
    ) ?>

    <?= $form->field($model, 'etiquetasSeleccionadas')->checkboxList($etiquetas, [
        'separator' => '<br>',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
