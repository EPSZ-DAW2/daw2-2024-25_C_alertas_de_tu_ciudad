<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->registerCssFile('@web/css/crud.css?v=' . time());
?>

<div class="imagen-form">
    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="form-group">
        <label class="control-label">Subir imagen</label>
        <input type="file" name="archivo" class="form-control" accept="image/*">
    </div>

    <?= $form->field($model, 'alerta_id')->textInput() ?>

    <?= $form->field($model, 'metadatos')->textarea(['rows' => 6, 'readonly' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<?php
$this->registerJs(<<<JS
$(document).ready(function() {
    $('input[type="file"]').change(function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            const nombre = file.name.replace(/\.[^/.]+$/, "");
            $('#imagen-nombre').val(nombre);

            const metadata = JSON.stringify({
                'nombre_original': file.name,
                'tipo': file.type,
                'tamano_bytes': file.size,
                'fecha_subida': new Date().toISOString()
            }, null, 2);

            $('#imagen-metadatos').val(metadata);
        }
    });
});
JS
);
?>