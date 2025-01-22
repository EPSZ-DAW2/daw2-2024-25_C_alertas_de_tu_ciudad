<?php
use yii\helpers\Html;

$this->title = $model->titulo;
?>

<h1><?= Html::encode($this->title) ?></h1>

<p><strong>描述:</strong> <?= Html::encode($model->descripcion) ?></p>
<p><strong>地点:</strong> <?= Html::encode($model->ubicacion) ?></p>
<p><strong>时间:</strong> <?= Html::encode($model->start_time) ?> - <?= Html::encode($model->end_time) ?></p>

<?php if ($model->image_url): ?>
    <p><img src="/<?= Html::encode($model->image_url) ?>" alt="警报图片" style="max-width: 100%;"></p>
<?php endif; ?>
