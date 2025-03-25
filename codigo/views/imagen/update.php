<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Imagen $model */

$this->title = 'Actualizar Imagen: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Imágenes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->registerCssFile('@web/css/crud.css?v=' . time());
?>
<div class="imagen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
