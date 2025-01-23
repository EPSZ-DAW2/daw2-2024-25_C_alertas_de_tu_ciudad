<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Registrar Usuario';
?>

    <h2>Registro de Usuario</h2>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<?php $form = ActiveForm::begin(['id' => 'registrar-form']); ?>

<?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

<?= $form->field($model, 'nick')->textInput() ?>

<?= $form->field($model, 'password1')->passwordInput() ?>

<?= $form->field($model, 'password2')->passwordInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Registrarse', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
