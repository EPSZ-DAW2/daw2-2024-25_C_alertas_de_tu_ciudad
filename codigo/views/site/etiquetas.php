<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Etiquetas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="etiqueta-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Selecciona una etiqueta para ver las alertas asociadas:</p>
    <ul>
        <?php foreach ($etiquetas as $etiqueta): ?>
            <li>
                <?= Html::a(Html::encode($etiqueta->nombre), Url::to(['site/etiquetas', 'id_etiqueta' => $etiqueta->id])) ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php if (!empty($alertas)): ?>
        <h2>Alertas con esta etiqueta</h2>
        <div class="row">
            <?php foreach ($alertas as $alerta): ?>
                <div class="col-md-4">
                    <div class="card" style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px; border-radius: 8px; box-shadow: 2px 2px 10px rgba(0,0,0,0.1);">
                        <h3 style="color: #007bff;"><?= Html::encode($alerta->titulo) ?></h3>
                        <p><strong>Descripción:</strong> <?= Html::encode($alerta->descripcion) ?></p>
                        <p><strong>Fecha de Creación:</strong> <?= Html::encode($alerta->fecha_creacion) ?></p>
                        <p><strong>Estado:</strong> <span class="badge badge-info"><?= Html::encode($alerta->estado) ?></span></p>
                        <?= Html::a('Ver más', ['alerta/view', 'id' => $alerta->id], ['class' => 'btn btn-primary btn-sm']) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <?php if ($etiquetaSeleccionada !== null): ?>
            <p style="color: red; font-weight: bold;">No hay alertas con esta etiqueta.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
