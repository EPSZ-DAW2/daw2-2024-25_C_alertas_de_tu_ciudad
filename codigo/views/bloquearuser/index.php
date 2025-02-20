<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $users app\models\Usuario[] */

$this->title = 'Gestionar el estado de prohibición del usuario';
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>nombre de usuario</th>
            <th>email</th>
            <th>estado</th>
            <th>operación</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= Html::encode($user->id) ?></td>
                <td><?= Html::encode($user->username) ?></td>
                <td><?= Html::encode($user->email) ?></td>
                <td>
                    <?= $user->locked ? '<span class="text-danger">bloquear</span>' : '<span class="text-success">normal</span>' ?>
                </td>
                <td>
                    <?php if ($user->locked): ?>
                        <?= Html::a('desbloquear', ['unlock', 'id' => $user->id], ['class' => 'btn btn-success btn-sm']) ?>
                    <?php else: ?>
                        <?= Html::a('bloquear', ['lock', 'id' => $user->id], ['class' => 'btn btn-danger btn-sm']) ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

