<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Categorías';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="categoria-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <ul>
        <?php foreach ($categorias as $categoria): ?>
            <li>
                <?= Html::a(Html::encode($categoria->nombre), Url::to(['alerta/index', 'id_categoria' => $categoria->id])) ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
