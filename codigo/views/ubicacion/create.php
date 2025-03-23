<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ubicacion $model */
$this->title = 'Crear Nueva Ubicación';
$this->params['breadcrumbs'][] = ['label' => 'Ubicaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/crud.css?v=' . time());
?>

<div class="ubicacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
