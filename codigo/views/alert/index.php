<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="container mt-4">
    <h2 class="text-center">Últimas Alertas</h2>
    <p><?= Html::a('Crear Alerta', ['create'], ['class' => 'btn btn-success']) ?></p>

    <div class="list-group">
        <?php foreach ($alertas as $alerta): ?>
            <a href="<?= Url::to(['view', 'id' => $alerta->id]) ?>" class="list-group-item list-group-item-action">
                <h5>⚠ <?= Html::encode($alerta->titulo) ?></h5>
                <p><?= Html::encode($alerta->descripcion) ?></p>
                <small>Publicado el <?= date('d/m/Y H:i', strtotime($alerta->fecha_inicio)) ?></small>
            </a>
        <?php endforeach; ?>
    </div>
</div>
