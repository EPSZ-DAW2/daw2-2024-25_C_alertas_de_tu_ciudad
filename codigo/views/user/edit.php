<?php
/** @var yii\web\View $this */
/** @var app\models\Usuario $user */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Información del Perfil';
?>

<div class="container mt-5">
    <div class="row">
        <!-- Panel izquierdo: avatar y estadísticas -->
        <div class="col-md-4 text-center">
            
            <h3 class="fw-bold"><?= Html::encode($user->username) ?></h3>
            <p class="text-muted"><?= Html::encode($user->nick) ?></p>
            <button type="button" class="btn btn-outline-primary btn-sm mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">Editar Perfil</button>
            <div class="mt-3">
                <?= Html::a('Cambio de Contraseña', ['user/change-password'], ['class' => 'btn btn-outline-secondary btn-sm']) ?>
            </div>
        </div>

        <!-- Panel derecho: contenido -->
        <div class="col-md-8">
            <ul class="nav nav-tabs mb-3" id="profileTabs" role="tablist">
                
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-success" id="notificaciones-tab" href="<?= \yii\helpers\Url::to(['notificacion/index']) ?>">Notificaciones</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link text-success" id="alertas-tab" href="<?= \yii\helpers\Url::to(['alertascreados/index']) ?>">Alertas Creados</a>
                </li>
            </ul>

            <div class="tab-content" id="profileTabsContent">
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar perfil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Editar Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['action' => ['user/edit'], 'method' => 'post']); ?>
                <?= $form->field($user, 'username')->textInput(['maxlength' => true]) ?>
                <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>
                <?= $form->field($user, 'nick')->textInput(['maxlength' => true]) ?>
               
                <div class="form-group mt-3">
                    <?= Html::submitButton('Guardar Cambios', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

