<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Categoria;
?>
<div class="etiqueta-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?php 
    // Obtener todas las categorías disponibles
    $categorias = ArrayHelper::map(Categoria::find()->all(), 'id', 'nombre');
    ?>

    <?= $form->field($model, 'categoriasSeleccionadas')->checkboxList($categorias, [
        'separator' => '<br>',
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
