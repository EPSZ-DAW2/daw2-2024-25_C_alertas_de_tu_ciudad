<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $users app\models\Usuario[] */

$this->title = 'Gestión de usuarios no confirmados';
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>nombre de usuario</th>
            <th>email</th>
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
                    <?= Html::a('Confirmar usuario', ['confirm', 'id' => $user->id], ['class' => 'btn btn-success']) ?>
                    <?= Html::a('Eliminar un usuario', ['delete', 'id' => $user->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => '¿Estás seguro que deseas eliminar este usuario?？',
                            'method' => 'post',
                        ],
                    ]) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

