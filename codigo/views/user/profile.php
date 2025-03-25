<?php
/** @var yii\web\View $this */
/** @var app\models\User $user */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = Yii::t('app', 'Profile - {username}', ['username' => Html::encode($user->username)]);
?>
<div class=\"container mt-5\">
    <h1 class=\"text-center\"><?= Yii::t('app', 'Welcome, {username}!', ['username' => Html::encode($user->username)]) ?></h1>
    <div class=\"row justify-content-center\">
        <div class=\"col-md-6\">
            <div class=\"card\">
                <div class=\"card-header bg-primary text-white text-center\">
                    <h4><?= Yii::t('app', 'Personal Information') ?></h4>
                </div>
                <div class=\"card-body\">
                    <p><strong><?= Yii::t('app', 'Username:') ?></strong> <?= Html::encode($user->username ?? 'N/A') ?></p>
                    <p><strong><?= Yii::t('app', 'Email:') ?></strong> <?= Html::encode($user->email ?? 'N/A') ?></p>
                </div>
            </div>
            <div class=\"text-center mt-4\">
                <?= Html::a(Yii::t('app', 'Edit Profile'), Url::to(['/user/edit']), ['class' => 'btn btn-warning']) ?>
                <?= Html::a(Yii::t('app', 'Eliminar'), Url::to(['/user/eliminar']), [
                    'class' => 'btn btn-danger',
                    'data-method' => 'post'
                ]) ?>
                <?= Html::a(Yii::t('app', 'Logout'), Url::to(['/site/logout']), [
                    'class' => 'btn btn-danger',
                    'data-method' => 'post'
                ]) ?>
            </div>
        </div>
    </div>
</div>