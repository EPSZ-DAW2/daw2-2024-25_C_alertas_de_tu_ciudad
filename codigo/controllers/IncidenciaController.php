<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Incidencia;
use app\models\IncidenciaSearch;
class IncidenciaController extends Controller
{
    public function actionIndex()
{
    if (!class_exists(IncidenciaSearch::class)) {
        throw new \Exception('Class IncidenciaSearch not found');
    }

    $searchModel = new IncidenciaSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}

    public function actionCreate()
    {
        $model = new Incidencia();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', ['model' => $model]);
    }

    protected function findModel($id)
    {
        if (($model = Incidencia::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
