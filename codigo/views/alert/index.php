<?php
use yii\helpers\Html;

$this->title = '警报列表';
?>

<h1><?= Html::encode($this->title) ?></h1>

<ul>
    <?php foreach ($alerts as $alert): ?>
        <li>
            <?= Html::a(Html::encode($alert->titulo), ['view', 'id' => $alert->id]) ?>
            (<?= Html::encode($alert->ubicacion) ?>, <?= Html::encode($alert->start_time) ?>)
        </li>
    <?php endforeach; ?>
</ul>
