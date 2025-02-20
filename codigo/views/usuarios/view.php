<?php
use yii\helpers\Html;

$this->title = $model->username;
?>

<h1>Detalles del Usuario: <?= Html::encode($this->title) ?></h1>



<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td><?= Html::encode($model->id) ?></td>
    </tr>
    <tr>
        <th>Username</th>
        <td><?= Html::encode($model->username) ?></td>
    </tr>
    <tr>
        <th>Email</th>
        <td><?= Html::encode($model->email) ?></td>
    </tr>
    <tr>
        <th>Fecha Creación</th>
        <td><?= Html::encode($model->created_at) ?></td>
    </tr>
    
    <tr>
        <th>Fecha de Registro</th>
        <td><?= Html::encode($model->register_date) ?></td>
    </tr>
    <tr>
        <th>Última Actualización</th>
        <td><?= Html::encode($model->updated_at) ?></td>
    </tr>
    <tr>
        <th>Rol</th>
        <td><?= Html::encode($model->role) ?></td>
    </tr>
    <tr>
        <th>Estado de Revisión</th>
        <td><?= Html::encode($model->estado_revisar) ?></td>
    </tr>
    <tr>
        <th>Respuesta</th>
        <td><?= Html::encode($model->respuesta ?: 'No hay respuesta') ?></td>
    </tr>
    <tr>
        <th>Nick</th>
        <td><?= Html::encode($model->nick ?: 'No definido') ?></td>
    </tr>
    <tr>
        <th>Intentos Fallidos</th>
        <td><?= Html::encode($model->failed_attempts) ?></td>
    </tr>
    
</table>
