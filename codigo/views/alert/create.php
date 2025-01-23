<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = '创建警报';
?>

<h1><?= Html::encode($this->title) ?></h1>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

<?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>
<?= $form->field($model, 'ubicacion')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'start_time')->input('datetime-local') ?>
<?= $form->field($model, 'end_time')->input('datetime-local') ?>
<?= $form->field($model, 'image_url')->fileInput() ?>

<div class="form-group">
    <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
