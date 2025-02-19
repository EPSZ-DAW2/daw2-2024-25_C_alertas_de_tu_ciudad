<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Eliminar Cuenta';
?>

<div class="container mt-5">
    <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-danger text-white text-center">
                    <h4>¿Por qué quieres eliminar tu cuenta?</h4>
                </div>
                <div class="card-body">
                    <?php $form = ActiveForm::begin(['method' => 'post']); ?>
                    <?= $form->field($user, 'eliminar_razon')->textarea(['rows' => 4]) ?>
                    <div class="text-center mt-3">
                        <?= Html::submitButton('Eliminar Cuenta', ['class' => 'btn btn-danger']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
