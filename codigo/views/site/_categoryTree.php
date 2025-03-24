<?php
/* @var $this yii\web\View */
/* @var $categorias app\models\Categoria[] */
?>
<div class="category-tree">
    <h2>Árbol de Categorías</h2>
    <ul>
        <?php foreach ($categorias as $categoria): ?>
            <li>
                <?= \yii\helpers\Html::encode($categoria->nombre) ?>
                <?php if (!empty($categoria->subcategorias)): ?>
                    <ul>
                        <?php foreach ($categoria->subcategorias as $subcategoria): ?>
                            <li><?= \yii\helpers\Html::encode($subcategoria->nombre) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
