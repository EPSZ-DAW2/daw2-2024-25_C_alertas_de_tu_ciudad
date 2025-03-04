<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $incidencias app\models\Incidencia[] */

$this->title = 'Lista de incidencias pendientes'; // 页面标题
?>

    <h1><?= Html::encode($this->title) ?></h1>

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

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Fecha de creación</th>
            <th>Prioridad</th>
            <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($incidencias as $incidencia): ?>
            <tr>
                <td><?= $incidencia->id ?></td>
                <td><?= Html::encode($incidencia->titulo) ?></td>
                <td><?= Html::encode($incidencia->descripcion) ?></td>
                <td><?= $incidencia->fecha_creacion ?></td>
                <td><?= ucfirst($incidencia->prioridad) ?></td>
                <td>
                    <?= Html::a('Procesar', ['procesar', 'id' => $incidencia->id], [
                        'class' => 'btn btn-success',
                        'data' => [
                            'confirm' => '¿Estás seguro de que deseas procesar esta incidencia?',
                            'method' => 'post',
                        ],
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
