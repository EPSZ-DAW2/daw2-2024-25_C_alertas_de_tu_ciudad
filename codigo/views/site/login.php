<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Iniciar Sesión';
?>
<div class="login-container">
    <h2><?= Html::encode($this->title) ?></h2>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'options' => ['class' => 'form-horizontal'], // Optional: adds horizontal layout if desired
    ]); ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'password')->passwordInput() ?>

    <?= $form->field($model, 'rememberMe')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton('Iniciar Sesión', [
            'class' => 'btn btn-success',
            'name' => 'login-button'
        ]) ?>
    </div>

    <div class="form-group">
        <p>
            ¿No tienes una cuenta?
            <?= Html::a('Regístrate aquí', ['auth/registrar'], ['class' => 'btn btn-primary']) ?>
        </p>
    </div>

    <?php ActiveForm::end(); ?>
</div>
