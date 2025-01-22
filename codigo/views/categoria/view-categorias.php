<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Categorías vinculadas a la etiqueta: ' . Html::encode($model->nombre);
$this->params['breadcrumbs'][] = ['label' => 'Etiquetas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="categoria-view-categorias">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Volver a Etiquetas', ['etiqueta/index'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => new \yii\data\ArrayDataProvider([
            'allModels' => $categorias,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'nombre',
            'descripcion',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('Ver', ['categoria/view', 'id' => $model->id], ['class' => 'btn btn-info btn-sm']);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
