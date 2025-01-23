<?php
use yii\widgets\LinkPager; // 引入分页控件

?>

<?php foreach ($comentarios as $comentario): ?>
    <div>
        <p><strong>Contenido:</strong> <?= $comentario->contenido ?></p>
        <p><strong>Número de Denuncias:</strong> <?= $comentario->numero_denuncias ?></p>
        <p>Estado: <?= $comentario->es_visible ? 'Visible' : 'Bloqueado' ?> | <?= $comentario->es_cerrado ? 'Cerrado' : 'Abierto' ?></p>

        <?php if ($comentario->es_visible): ?>
            <a href="<?= \yii\helpers\Url::to(['comentarios/bloquear-hilo', 'id' => $comentario->id]) ?>">Bloquear</a>
        <?php else: ?>
            <a href="<?= \yii\helpers\Url::to(['comentarios/desbloquear-hilo', 'id' => $comentario->id]) ?>">Desbloquear</a>
        <?php endif; ?>

        <?php if ($comentario->es_cerrado): ?>
            <a href="<?= \yii\helpers\Url::to(['comentarios/reabrir-hilo', 'id' => $comentario->id]) ?>">Reabrir</a>
        <?php else: ?>
            <a href="<?= \yii\helpers\Url::to(['comentarios/cerrar-hilo', 'id' => $comentario->id]) ?>">Cerrar</a>
        <?php endif; ?>
    </div>
    <hr>
<?php endforeach; ?>

<!-- 分页控件 -->
<?= LinkPager::widget([
    'pagination' => $pagination,
    'options' => ['class' => 'pagination justify-content-center'], // 自定义分页样式
]) ?>
