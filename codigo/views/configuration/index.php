<?php
use yii\helpers\Html;

$this->title = 'Gestión de Configuraciones';
?>

<h1><?= Html::encode($this->title) ?></h1>

<table class="table table-bordered">
    <thead>
    <tr>
        <th>Clave</th>
        <th>Valor</th>
        <th>Descripción</th>
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($configurations as $configuration): ?>
        <tr>
            <td><?= Html::encode($configuration->key_name) ?></td>
            <td><?= Html::encode($configuration->value) ?></td>
            <td><?= Html::encode($configuration->description) ?></td>
            <td>
                <?= Html::a('Actualizar', ['update', 'id' => $configuration->id], ['class' => 'btn btn-primary']) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
