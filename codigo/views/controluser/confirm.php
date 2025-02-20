<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $user app\models\Usuario */

$this->title = 'Confirmar usuario';
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>Confirmando usuario: <?= Html::encode($user->username) ?> (<?= Html::encode($user->email) ?>)</p>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($user, 'phone')->textInput(['placeholder' => 'Introduzca el número de teléfono'])->label('número de teléfono') ?>

    <div class="form-group">
        <?= Html::submitButton('confirmar', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
