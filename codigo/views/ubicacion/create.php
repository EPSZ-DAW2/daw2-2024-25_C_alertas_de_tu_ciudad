<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Ubicacion $model */
$this->title = 'Crear Nueva Ubicacion';
$this->params['breadcrumbs'][] = ['label' => 'Ubicaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss("
    h1 {
        text-align: center;
        margin: 50px;
    }
");
?>

<div class="ubicacion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
