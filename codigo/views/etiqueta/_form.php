<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Categoria;
use app\models\Alerta;
?>
<div class="etiqueta-form">
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?php 
    // Obtener todas las categorías y alertas disponibles
    $categorias = ArrayHelper::map(Categoria::find()->all(), 'id', 'nombre');
    $alertas = ArrayHelper::map(Alerta::find()->all(), 'id', 'titulo');
    ?>

    <div class="row">
        <div class="col-md-6">
            <h4>Categorías</h4>
            <?= $form->field($model, 'categoriasSeleccionadas')->checkboxList($categorias, [
                'separator' => '<br>',
            ]) ?>
        </div>
        <div class="col-md-6">
            <h4>Alertas</h4>
            <?= $form->field($model, 'alertasSeleccionadas')->checkboxList($alertas, [
                'separator' => '<br>',
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
