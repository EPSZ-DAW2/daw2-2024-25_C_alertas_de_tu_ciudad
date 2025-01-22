<?php
use yii\helpers\Html;

$this->title = 'Gestión de Respaldos';
?>

<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Crear Respaldo', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nombre del Archivo</th>
        <th>Fecha de Creación</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($backups as $backup): ?>
        <tr>
            <td><?= $backup->id ?></td>
            <td><?= Html::encode($backup->file_name) ?></td>
            <td><?= $backup->created_at ?></td>
            <td>
                <?= Html::a('Restaurar', ['restore', 'id' => $backup->id], ['class' => 'btn btn-primary', 'data-confirm' => '¿Está seguro de que desea restaurar este respaldo?']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

