<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Categorías';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Selecciona una categoría para ver las alertas asociadas:</p>
    <ul>
        <?php foreach ($categorias as $categoria): ?>
            <li>
                <?= Html::a(Html::encode($categoria->nombre), Url::to(['site/categorias', 'id_categoria' => $categoria->id])) ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <?php if (!empty($alertas)): ?>
        <h2>Alertas en esta categoría</h2>
        <ul>
            <?php foreach ($alertas as $alerta): ?>
                <li>
                    <?= Html::a(Html::encode($alerta->titulo), ['alerta/view', 'id' => $alerta->id]) ?>
                    (<?= Html::encode($alerta->fecha_creacion) ?>)
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <?php if ($categoriaSeleccionada !== null): ?>
            <p>No hay alertas en esta categoría.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>
