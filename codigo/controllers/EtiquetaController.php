<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Etiqueta;
use app\models\search\EtiquetaSearch;
use yii\web\NotFoundHttpException;

class EtiquetaController extends Controller
{
    /**
     * Configurar los comportamientos del controlador.
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
     * Muestra una lista de etiquetas.
     */
    public function actionIndex()
    {
        $searchModel = new EtiquetaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Crea una nueva etiqueta.
     * La asociación de categorías y alertas se gestiona en el modelo (afterSave).
     */
    public function actionCreate()
    {
        $model = new Etiqueta();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Se actualizan automáticamente las asociaciones en el modelo.
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Actualiza una etiqueta existente.
     * La asociación de categorías y alertas se gestiona en el modelo (afterSave).
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Las relaciones se actualizan en el modelo.
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Elimina una etiqueta si no tiene vínculos.
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        
        if ($model->canBeDeleted()) {
            $model->delete();
            return $this->redirect(['index']);
        }

        Yii::$app->session->setFlash('error', 'No se puede eliminar la etiqueta porque tiene vínculos.');
        return $this->redirect(['index']);
    }

    /**
     * Ver las categorías vinculadas a una etiqueta.
     */
    public function actionViewCategorias($id)
    {
        $model = $this->findModel($id);

        return $this->render('//categoria/view-categorias', [
            'model' => $model,
            'categorias' => $model->getCategorias()->all(),
        ]);
    }

    /**
     * Ver las alertas vinculadas a una etiqueta.
     */
    public function actionViewAlertas($id)
    {
        $model = $this->findModel($id);

        return $this->render('view-alertas', [
            'model' => $model,
            'alertas' => $model->getAlertas(),
        ]);
    }

    /**
     * Ver la etiqueta creada.
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Encuentra el modelo de Etiqueta basado en su ID.
     */
    protected function findModel($id)
    {
        if (($model = Etiqueta::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La etiqueta solicitada no existe.');
    }
}
