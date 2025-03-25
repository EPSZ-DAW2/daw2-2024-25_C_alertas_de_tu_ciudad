<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Categorías';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container mt-4">
    <div class="card p-3 mb-4">
        <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
        <p class="text-center">Selecciona una categoría para ver las alertas asociadas:</p>
        <ul class="list-group mb-4">
            <?php foreach ($categorias as $categoria): ?>
                <li class="list-group-item">
                    <?= Html::a(Html::encode($categoria->nombre), Url::to(['site/categorias', 'id_categoria' => $categoria->id])) ?>
                </li>
            <?php endforeach; ?>
        </ul>

        <?php if (!empty($alertas)): ?>
            <h2 class="text-center">Alertas en esta categoría</h2>
            <div class="row">
                <?php foreach ($alertas as $alerta): ?>
                    <div class="col-md-4">
                        <div class="card mb-4" style="border: 1px solid #ddd; border-radius: 8px; box-shadow: 2px 2px 10px rgba(0,0,0,0.1);">
                            <div class="card-body">
                                <h3 style="color: #007bff;"><?= Html::encode($alerta->titulo) ?></h3>
                                <p><strong>Fecha de Creación:</strong> <?= Html::encode($alerta->fecha_creacion) ?></p>
                                <?= Html::a('Ver más', ['alerta/view', 'id' => $alerta->id], ['class' => 'btn btn-primary btn-sm']) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <?php if ($categoriaSeleccionada !== null): ?>
                <p class="text-center text-danger font-weight-bold">No hay alertas en esta categoría.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
