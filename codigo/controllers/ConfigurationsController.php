<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Configuration;
use yii\web\NotFoundHttpException;

class ConfigurationsController extends Controller
{
    // Listar todas las configuraciones
    public function actionIndex()
    {
        $configurations = Configuration::find()->all();
        return $this->render('//configuration/index', [
            'configurations' => $configurations,
        ]);
    }

    // Actualizar una configuración
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }

        return $this->render('//configuration/update', [
            'model' => $model,
        ]);
    }

    // Buscar modelo por ID
    protected function findModel($id)
    {
        if (($model = Configuration::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('La configuración solicitada no existe.');
    }
}
