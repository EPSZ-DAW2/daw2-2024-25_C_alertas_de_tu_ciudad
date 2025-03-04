<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Título</th>
        <th>Descripción</th>
        <th>Fecha de Vencimiento</th>
        <th>Estado</th> <!-- 显示状态 -->
        <th>Acciones</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($alertas as $alerta): ?>
        <tr>
            <td><?= $alerta->id ?></td>
            <td><?= $alerta->titulo ?></td>
            <td><?= $alerta->descripcion ?></td>
            <td><?= $alerta->fecha_expiracion ?></td>
            <td>
                <!-- 添加状态显示 -->
                <?php if ($alerta->estado === 'completado'): ?>
                    <span class="badge bg-success">Completada</span>
                <?php else: ?>
                    <span class="badge bg-warning">Pendiente</span>
                <?php endif; ?>
            </td>
            <td>
                <!-- 动作按钮 -->
                <?php if ($alerta->estado === 'pendiente'): ?>
                    <a href="<?= \yii\helpers\Url::to(['gestion-alertas/completar', 'id' => $alerta->id]) ?>" class="btn btn-success btn-sm">Completar</a>
                <?php endif; ?>
                <a href="<?= \yii\helpers\Url::to(['gestion-alertas/eliminar', 'id' => $alerta->id]) ?>" class="btn btn-danger btn-sm">Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>



