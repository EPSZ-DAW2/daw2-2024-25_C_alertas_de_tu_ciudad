<?php
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UbicacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ubicaciones';
?>
<?php $this->registerCssFile('@web/css/ubicacion.css'); ?>


<h1><?= Html::encode($this->title) ?></h1>

<p>
    <?= Html::a('Crear Ubicación', ['create'], ['class' => 'btn btn-success']) ?>
</p>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        'id',
        'nombre',
        [
            'attribute' => 'ub_code_padre',
            'label' => 'Ubicación Padre',
            'value' => function($model) {
                return $model->ubCodePadre ? $model->ubCodePadre->nombre : '(Sin padre)';
            }
        ],
        ['class' => 'yii\grid\ActionColumn'],
    ],
]); ?>
