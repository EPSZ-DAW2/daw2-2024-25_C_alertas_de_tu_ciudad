<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Etiquetas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-4">
    <div class="card p-3 mb-4">
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
        <p class="text-center">Selecciona una etiqueta para ver las alertas asociadas:</p>
        <ul class="list-group mb-4">
            <?php foreach ($etiquetas as $etiqueta): ?>
                <li class="list-group-item">
                    <?= Html::a(Html::encode($etiqueta->nombre), Url::to(['site/etiquetas', 'id_etiqueta' => $etiqueta->id])) ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if (!empty($alertas)): ?>
            <h2 class="text-center">Alertas con esta etiqueta</h2>
            <div class="row">
                <?php foreach ($alertas as $alerta): ?>
                    <div class="col-md-4">
                        <div class="card mb-4" style="border: 1px solid #ddd; border-radius: 8px; box-shadow: 2px 2px 10px rgba(0,0,0,0.1);">
                            <div class="card-body">
                                <h3 style="color: #007bff;"><?= Html::encode($alerta->titulo) ?></h3>
                                <p><strong>Descripción:</strong> <?= Html::encode($alerta->descripcion) ?></p>
                                <p><strong>Fecha de Creación:</strong> <?= Html::encode($alerta->fecha_creacion) ?></p>
                                <p>
                                    <strong>Estado:</strong>
                                    <span class="badge badge-info"><?= Html::encode($alerta->estado) ?></span>
                                </p>
                                <?= Html::a('Ver más', ['alerta/view', 'id' => $alerta->id], ['class' => 'btn btn-primary btn-sm']) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <?php if ($etiquetaSeleccionada !== null): ?>
                <p class="text-center text-danger font-weight-bold">
                    No hay alertas con esta etiqueta.
                </p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
