<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Usuario $user */

$this->title = 'Cambiar Contraseña';
?>

<div class="container mt-5">
    <h2 class="text-center"><?= Html::encode($this->title) ?></h2>
    <p class="text-muted text-center">Por favor completa el formulario para cambiar tu contraseña.</p>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Muestra mensajes de éxito o error -->
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

            <?php $form = ActiveForm::begin([
                'id' => 'change-password-form',
                'method' => 'post',
            ]); ?>

            <!-- Campo para la contraseña actual -->
            <?= $form->field($user, 'currentPassword')->passwordInput([
                'maxlength' => true,
                'placeholder' => 'Introduce tu contraseña actual'
            ])->label('Contraseña Actual') ?>

            <!-- Campo para la nueva contraseña -->
            <?= $form->field($user, 'newPassword')->passwordInput([
                'maxlength' => true,
                'placeholder' => 'Introduce tu nueva contraseña'
            ])->label('Nueva Contraseña') ?>

            <!-- Campo para confirmar la nueva contraseña -->
            <?= $form->field($user, 'confirmPassword')->passwordInput([
                'maxlength' => true,
                'placeholder' => 'Confirma tu nueva contraseña'
            ])->label('Confirmar Nueva Contraseña') ?>

            <div class="form-group text-center">
                <?= Html::submitButton('Guardar Cambios', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
