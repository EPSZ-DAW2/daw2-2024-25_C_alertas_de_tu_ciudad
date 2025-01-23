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
            <!-- Avatar -->
            <img 
                src="/path/to/avatar.png" 
                alt="Avatar del Usuario" 
                class="rounded-circle mb-3" 
                style="width: 120px; height: 120px; object-fit: cover;"
            >

            <!-- Nombre de usuario -->
            <h3 class="fw-bold"><?= Html::encode($user->username) ?></h3>

            <!-- Apodo -->
            <p class="text-muted"><?= Html::encode($user->nick) ?></p>

            <!-- Botón para editar perfil -->
            <div class="mt-3">
                <button 
                    type="button" 
                    class="btn btn-outline-primary btn-sm" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editProfileModal"
                >
                    Editar Perfil
                </button>
            </div>

            <!-- Estadísticas -->
            <div class="row mt-4">
                <div class="col-6 text-center border-end border-bottom">
                    <a href="/user/followed" class="text-decoration-none text-dark">
                        <p class="text-muted">Personas que sigo</p>
                        <h4>0</h4>
                    </a>
                </div>
                <div class="col-6 text-center border-bottom">
                    <a href="/user/followers" class="text-decoration-none text-dark">
                        <p class="text-muted">Personas que me siguen</p>
                        <h4>0</h4>
                    </a>
                </div>
                <div class="col-6 text-center border-end">
                    <a href="/user/likes" class="text-decoration-none text-dark">
                        <p class="text-muted">Me gusta recibidos</p>
                        <h4>0</h4>
                    </a>
                </div>
                <div class="col-6 text-center">
                    <a href="/user/recommendations" class="text-decoration-none text-dark">
                        <p class="text-muted">Recomendaciones</p>
                        <h4>0</h4>
                    </a>
                </div>
            </div>
        </div>

        <!-- Panel derecho: contenido -->
        <div class="col-md-8">
            <!-- Navegación de pestañas -->
            <ul class="nav nav-tabs mb-3" id="profileTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <a 
                        class="nav-link active text-danger" 
                        id="posts-tab" 
                        data-bs-toggle="tab" 
                        href="#posts" 
                        role="tab" 
                        aria-controls="posts" 
                        aria-selected="true"
                    >
                        Publicaciones
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a 
                        class="nav-link text-primary" 
                        id="replies-tab" 
                        data-bs-toggle="tab" 
                        href="#replies" 
                        role="tab" 
                        aria-controls="replies" 
                        aria-selected="false"
                    >
                        Respuestas
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a 
                        class="nav-link text-success" 
                        id="recommendations-tab" 
                        data-bs-toggle="tab" 
                        href="#recommendations" 
                        role="tab" 
                        aria-controls="recommendations" 
                        aria-selected="false"
                    >
                        Recomendaciones
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a 
                        class="nav-link text-warning" 
                        id="favorites-tab" 
                        data-bs-toggle="tab" 
                        href="#favorites" 
                        role="tab" 
                        aria-controls="favorites" 
                        aria-selected="false"
                    >
                        Favoritos
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a 
                        class="nav-link text-info" 
                        id="follows-tab" 
                        data-bs-toggle="tab" 
                        href="#follows" 
                        role="tab" 
                        aria-controls="follows" 
                        aria-selected="false"
                    >
                        Seguimientos
                    </a>
                </li>
            </ul>

            <!-- Contenido de las pestañas -->
            <div class="tab-content" id="profileTabsContent">
                <!-- Publicaciones -->
                <div 
                    class="tab-pane fade show active" 
                    id="posts" 
                    role="tabpanel" 
                    aria-labelledby="posts-tab"
                >
                    <div class="text-center">
                        <img 
                            src="/path/to/placeholder.png" 
                            alt="Sin datos" 
                            class="mb-3" 
                            style="width: 150px;"
                        >
                        <p class="text-muted">No hay datos. ¡Explora otras secciones!</p>
                    </div>
                </div>

                <!-- Respuestas -->
                <div 
                    class="tab-pane fade" 
                    id="replies" 
                    role="tabpanel" 
                    aria-labelledby="replies-tab"
                >
                    <div class="text-center">
                        <p class="text-muted">Aquí estarán tus respuestas. Estamos trabajando en ello.</p>
                    </div>
                </div>

                <!-- Recomendaciones -->
                <div 
                    class="tab-pane fade" 
                    id="recommendations" 
                    role="tabpanel" 
                    aria-labelledby="recommendations-tab"
                >
                    <div class="text-center">
                        <p class="text-muted">Aquí estarán tus recomendaciones. Estamos trabajando en ello.</p>
                    </div>
                </div>

                <!-- Favoritos -->
                <div 
                    class="tab-pane fade" 
                    id="favorites" 
                    role="tabpanel" 
                    aria-labelledby="favorites-tab"
                >
                    <div class="text-center">
                        <p class="text-muted">Aquí estarán tus favoritos. Estamos trabajando en ello.</p>
                    </div>
                </div>

                <!-- Seguimientos -->
                <div 
                    class="tab-pane fade" 
                    id="follows" 
                    role="tabpanel" 
                    aria-labelledby="follows-tab"
                >
                    <div class="text-center">
                        <p class="text-muted">Aquí estará tu lista de seguimientos. Estamos trabajando en ello.</p>
                    </div>
                </div>
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
                <button 
                    type="button" 
                    class="btn-close" 
                    data-bs-dismiss="modal" 
                    aria-label="Cerrar"
                ></button>
            </div>
            <div class="modal-body">
                <!-- Formulario de edición -->
                <?php $form = ActiveForm::begin([
                    'action' => ['user/edit'], // Asegúrate de que apunta a UserController::actionEdit
                    'method' => 'post',
                ]); ?>

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
