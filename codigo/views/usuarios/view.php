<?php
use yii\helpers\Html;

$this->title = $model->username;
?>

<h1>Detalles del Usuario: <?= Html::encode($this->title) ?></h1>

<p><?= Html::a('Actualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?></p>

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
</table>
