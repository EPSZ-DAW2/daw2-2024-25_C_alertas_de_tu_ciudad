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
            <img 
                src="/path/to/avatar.png" 
                alt="Avatar del Usuario" 
                class="rounded-circle mb-3" 
                style="width: 120px; height: 120px; object-fit: cover;"
            >
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
                    <a class="nav-link active text-danger" id="posts-tab" data-bs-toggle="tab" href="#posts" role="tab" aria-controls="posts" aria-selected="true">Publicaciones</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-primary" id="eliminacion-tab" data-bs-toggle="tab" href="#eliminacion" role="tab" aria-controls="eliminacion" aria-selected="false">Eliminación</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-success" id="notificaciones-tab" data-bs-toggle="tab" href="#notificaciones" role="tab" aria-controls="notificaciones" aria-selected="false">Notificaciones</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link text-warning" id="alertas-tab" data-bs-toggle="tab" href="#alertas" role="tab" aria-controls="alertas" aria-selected="false">Alertas Creados</a>
                </li>
            </ul>

            <div class="tab-content" id="profileTabsContent">
                <!-- Publicaciones -->
                <div class="tab-pane fade show active" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                    <textarea id="postContent" class="form-control mb-3" rows="3" placeholder="Escribe tu publicación..."></textarea>
                    <button id="publishBtn" class="btn btn-primary">Publicar</button>
                </div>

                <!-- Eliminación -->
                <div class="tab-pane fade" id="eliminacion" role="tabpanel" aria-labelledby="eliminacion-tab">
                    <ul id="eliminarList" class="list-group"></ul>
                </div>

                <!-- Notificaciones -->
                <div class="tab-pane fade" id="notificaciones" role="tabpanel" aria-labelledby="notificaciones-tab">
                    <ul id="notificationList" class="list-group"></ul>
                </div>

                <!-- Alertas Creados -->
                <div class="tab-pane fade" id="alertas" role="tabpanel" aria-labelledby="alertas-tab">
                    <ul id="alertList" class="list-group">
                        <!-- 示例事件 -->
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Evento 1
                            <input type="checkbox" class="form-check-input me-2 alert-checkbox">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Evento 2
                            <input type="checkbox" class="form-check-input me-2 alert-checkbox">
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Evento 3
                            <input type="checkbox" class="form-check-input me-2 alert-checkbox">
                        </li>
                    </ul>
                    <button id="createAlertBtn" class="btn btn-warning mt-3">Crear Alertas</button>
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <?php $form = ActiveForm::begin(['action' => ['user/edit'], 'method' => 'post']); ?>
                <?= $form->field($user, 'username')->textInput(['maxlength' => true]) ?>
                <?= $form->field($user, 'email')->textInput(['maxlength' => true]) ?>
                <?= $form->field($user, 'nick')->textInput(['maxlength' => true]) ?>
                <?= $form->field($user, 'surname')->textInput(['maxlength' => true]) ?>
                <div class="form-group mt-3">
                    <?= Html::submitButton('Guardar Cambios', ['class' => 'btn btn-primary']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

<script>
    const publishBtn = document.getElementById('publishBtn');
    const postContent = document.getElementById('postContent');
    const eliminarList = document.getElementById('eliminarList');
    const notificationList = document.getElementById('notificationList');
    const alertList = document.getElementById('alertList');
    const createAlertBtn = document.getElementById('createAlertBtn');


    publishBtn.addEventListener('click', () => {
        const content = postContent.value.trim(); 
        if (content) {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = `
                ${content}
                <div>
                    <button class="btn btn-danger btn-sm deleteBtn">Eliminar</button>
                    <button class="btn btn-secondary btn-sm requestBtn">Solicitar</button>
                </div>
            `;
            eliminarList.appendChild(li);
            postContent.value = ''; 
        }
    });


    eliminarList.addEventListener('click', (e) => {
        if (e.target.classList.contains('deleteBtn')) {
            e.target.closest('li').remove();
        }

        if (e.target.classList.contains('requestBtn')) {
            const li = e.target.closest('li');
            const content = li.firstChild.textContent.trim();

            
            const notification = document.createElement('li');
            notification.className = 'list-group-item d-flex justify-content-between align-items-center';
            notification.innerHTML = `
                ${content}
                <button class="btn btn-info btn-sm addToAlertsBtn">Agregar a Alertas</button>
            `;
            notificationList.appendChild(notification);

            
            updateAlerts();

            li.remove(); 
        }
    });


    notificationList.addEventListener('click', (e) => {
        if (e.target.classList.contains('addToAlertsBtn')) {
            const li = e.target.closest('li');
            const content = li.firstChild.textContent.trim();

        
            const alertItem = document.createElement('li');
            alertItem.className = 'list-group-item d-flex justify-content-between align-items-center';
            alertItem.innerHTML = `
                ${content}
                <input type="checkbox" class="form-check-input me-2 alert-checkbox">
            `;
            alertList.appendChild(alertItem);

         
            li.remove();
        }
    });


    createAlertBtn.addEventListener('click', () => {
        const checkboxes = document.querySelectorAll('.alert-checkbox');
        checkboxes.forEach((checkbox) => {
            if (checkbox.checked) {
                const parentLi = checkbox.closest('li');
                if (!parentLi.querySelector('.alert-icon')) {
                    const alertIcon = document.createElement('span');
                    alertIcon.className = 'badge bg-danger ms-2 alert-icon';
                    alertIcon.textContent = '⚠️'; 
                    parentLi.appendChild(alertIcon);
                }
                checkbox.checked = false; 
            }
        });
    });


    function updateAlerts() {
        const notifications = notificationList.querySelectorAll('.list-group-item');
        alertList.innerHTML = ''; 
        notifications.forEach((notification) => {
            const content = notification.firstChild.textContent.trim();
            const alertItem = document.createElement('li');
            alertItem.className = 'list-group-item d-flex justify-content-between align-items-center';
            alertItem.innerHTML = `
                ${content}
                <input type="checkbox" class="form-check-input me-2 alert-checkbox">
            `;
            alertList.appendChild(alertItem);
        });
    }
</script>
