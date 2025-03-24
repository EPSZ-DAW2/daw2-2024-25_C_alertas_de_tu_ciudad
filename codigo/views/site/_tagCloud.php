<?php
/* @var $this yii\web\View */
/* @var $etiquetas app\models\Etiqueta[] */
?>
<div class="tag-cloud">
    <h2>Nube de Etiquetas</h2>
    <div>
        <?php foreach ($etiquetas as $etiqueta): 
            // Opcional: calcular un tamaño basado en la cantidad de alertas asociadas
            $count = $etiqueta->getAlertasDirect()->count();
            $fontSize = 12 + ($count * 2);
        ?>
            <span style="font-size: <?= $fontSize ?>px; margin-right: 10px;">
                <?= \yii\helpers\Html::a(\yii\helpers\Html::encode($etiqueta->nombre), ['site/busqueda-avanzada', 'etiqueta' => $etiqueta->id]) ?>
            </span>
        <?php endforeach; ?>
    </div>
</div>
