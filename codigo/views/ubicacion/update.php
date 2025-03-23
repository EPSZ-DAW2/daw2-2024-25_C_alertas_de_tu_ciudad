<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ubicacion $model */

$this->title = 'Actualizar Ubicación: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Ubicacions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->registerCssFile('@web/css/crud.css?v=' . time());

?>

<div class="ubicacion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
