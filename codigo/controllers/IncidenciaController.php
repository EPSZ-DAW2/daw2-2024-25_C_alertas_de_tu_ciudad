<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Incidencia;
use app\models\IncidenciaSearch;
use yii\web\NotFoundHttpException;

class IncidenciaController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new IncidenciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionResponder($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Respuesta guardada exitosamente.');
            return $this->redirect(['index']);
        }

        return $this->render('responder', [
            'model' => $model,
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

        throw new NotFoundHttpException('La incidencia no existe.');
    }
}
