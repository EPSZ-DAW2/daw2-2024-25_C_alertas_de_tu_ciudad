<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\models\Categoria;
use app\models\search\CategoriaSearch;

class CategoriaController extends Controller
{
    /**
     * Configuración de los comportamientos del controlador.
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lista todas las categorías.
     */
    public function actionIndex()
    {
        $searchModel = new CategoriaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Crea una nueva categoría.
     */
    public function actionCreate()
    {
        $model = new Categoria();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Actualiza una categoría existente.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Muestra los detalles de una categoría.
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Elimina una categoría si no tiene alertas asociadas.
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        if ($model->getAlertas()->count() === 0) {
            $model->delete();
            return $this->redirect(['index']);
        }

        Yii::$app->session->setFlash('error', 'No se puede eliminar la categoría porque tiene alertas asociadas.');
        return $this->redirect(['index']);
    }

    /**
     * Encuentra un modelo de categoría basado en su ID.
     */
    protected function findModel($id)
    {
        if (($model = Categoria::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La categoría solicitada no existe.');
    }
}
