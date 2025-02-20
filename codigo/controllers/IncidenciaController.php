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
        $model = $this->findModel($id); // 加载指定 ID 的记录
    
        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'La respuesta se guardó correctamente.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo guardar la respuesta.');
            }
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

    
    

    protected function findModel($id)
{
    if (($model = Incidencia::findOne($id)) !== null) {
        return $model;
    }

    throw new NotFoundHttpException('La incidencia no existe.');
}

    public function actionRevisar($id)
    {
        $model = $this->findModel($id);
    
        // 更新状态和修订日期
        $model->estado = 'revisada';
        $model->fecha_revision = date('Y-m-d H:i:s');
    
        // 保存模型
        if ($model->save(false)) { // 使用 false 跳过验证规则
            Yii::$app->session->setFlash('success', 'La incidencia se ha marcado como revisada.');
        } else {
            Yii::$app->session->setFlash('error', 'No se pudo marcar la incidencia como revisada. Errores: ' . json_encode($model->getErrors()));
        }
    
        return $this->redirect(['index']);
    }
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
    
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'La incidencia se ha actualizado correctamente.');
            return $this->redirect(['index']);
        } else {
           // Yii::$app->session->setFlash('error', 'No se pudo actualizar la incidencia.');
        }
    
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    
}
