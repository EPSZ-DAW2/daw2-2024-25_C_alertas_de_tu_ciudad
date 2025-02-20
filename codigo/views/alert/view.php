<?php
use yii\helpers\Html;
?>

<div class="container mt-4">
    <h2 class="text-center"><?= Html::encode($alerta->titulo) ?></h2>
    <p><strong>Descripción:</strong> <?= Html::encode($alerta->descripcion) ?></p>
    <p><strong>Fecha de Inicio:</strong> <?= date('d/m/Y H:i', strtotime($alerta->fecha_inicio)) ?></p>
    <p><strong>Duración Estimada:</strong> <?= $alerta->duracion_estimada ? $alerta->duracion_estimada . ' minutos' : 'N/A' ?></p>
    <p><strong>Ubicación:</strong> <?= $alerta->lugar ? Html::encode($alerta->lugar->nombre) : 'No especificado' ?></p>

    <p>
        <?= Html::a('Editar', ['update', 'id' => $alerta->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Eliminar', ['delete', 'id' => $alerta->id], [
            'class' => 'btn btn-danger',
            'data' => ['confirm' => '¿Estás seguro?', 'method' => 'post'],
        ]) ?>
    </p>
</div>
