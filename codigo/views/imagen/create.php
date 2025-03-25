<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Imagen $model */

$this->title = 'Crear Nueva Imagen';
$this->params['breadcrumbs'][] = ['label' => 'Imágenes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile('@web/css/crud.css?v=' . time());
?>

<div class="imagen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
