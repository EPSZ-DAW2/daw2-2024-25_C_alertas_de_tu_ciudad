<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\PropuestaEtiqueta;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class PropuestaController extends Controller
{


    
/*
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['proponer-etiqueta'], // restringir solo esta acción, o todas si es necesario
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Solo usuarios autenticados
                    ],
                ],
            ],
            // Otros comportamientos, como VerbFilter...
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
*/


    /**
     * Acción para proponer una nueva etiqueta o cambio.
     */
    public function actionProponerEtiqueta()
    {
        $model = new PropuestaEtiqueta();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Propuesta enviada exitosamente.');
            return $this->redirect(['proponer-etiqueta']);
        }

        return $this->render('propuesta-etiqueta', [
            'model' => $model,
        ]);
    }

    /**
     * (Opcional) Acción para ver las propuestas realizadas.
     */
    public function actionMisPropuestas()
    {
        $propuestas = PropuestaEtiqueta::find()->all();
        return $this->render('mis-propuestas', [
            'propuestas' => $propuestas,
        ]);
    }

    public function actionIndex()
    {
        // Listado de todas las propuestas ordenadas por fecha de creación (descendente)
        $query = PropuestaEtiqueta::find()->orderBy(['creado_en' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAprobar($id)
    {
        $model = $this->findModel($id);
        
        // Crear nueva etiqueta a partir de la propuesta
        $etiqueta = new \app\models\Etiqueta();
        $etiqueta->nombre = $model->nombre;
        $etiqueta->descripcion = $model->descripcion;
        
        if ($etiqueta->save()) {
            // Si se crea la etiqueta correctamente, se marca la propuesta como aprobada
            $model->estado = 'aprobado';
            $model->save(false);
            Yii::$app->session->setFlash('success', 'La propuesta ha sido aprobada y la etiqueta se ha creado.');
        } else {
            Yii::$app->session->setFlash('error', 'Error al crear la etiqueta a partir de la propuesta.');
        }
        
        return $this->redirect(['index']);
    }


    public function actionRechazar($id)
    {
        $model = $this->findModel($id);
        $model->estado = 'rechazado';
        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'La propuesta ha sido rechazada.');
        } else {
            Yii::$app->session->setFlash('error', 'Error al rechazar la propuesta.');
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = PropuestaEtiqueta::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('La propuesta solicitada no existe.');
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

}
