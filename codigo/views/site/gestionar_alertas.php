<h1>Gestionar Alertas</h1>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>

<h2>Crear Nueva Alerta</h2>
<form method="post">
    <input type="hidden" name="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
    <div class="form-group">
        <label for="titulo">Título</label>
        <input type="text" name="titulo" id="titulo" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Crear Alerta</button>
</form>

<h2>Mis Alertas</h2>
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descripción</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($alertas as $alerta): ?>
            <tr>
                <td><?= $alerta->id ?></td>
                <td><?= htmlspecialchars($alerta->titulo) ?></td>
                <td><?= htmlspecialchars($alerta->descripcion) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
