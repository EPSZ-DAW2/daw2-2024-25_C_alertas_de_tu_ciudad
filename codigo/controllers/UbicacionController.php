<?php

namespace app\controllers;

use Yii;
use app\models\Ubicacion;
use app\models\UbicacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use DateTime;

/**
 * UbicacionController implementa las acciones CRUD para el modelo Ubicacion.
 */
class UbicacionController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new UbicacionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Ubicacion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

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

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Ubicacion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La ubicación no existe.');
    }

    public function actionLibres()
    {
        $request = Yii::$app->request;
        $currentFilters = $request->get('filters', []);
        $currentFilters = is_array($currentFilters) ? $currentFilters : explode(',', $currentFilters);

        if (empty($currentFilters)) {
            $currentFilters = ['todas'];
        }

        if ($request->get('toggle')) {
            $filter = $request->get('toggle');

            if ($filter === 'todas') {
                $currentFilters = ['todas'];
            } else {
                $currentFilters = array_diff($currentFilters, ['todas']);

                if ($filter === 'revisada') {
                    $currentFilters = array_diff($currentFilters, ['no_revisada']);
                }
                if ($filter === 'no_revisada') {
                    $currentFilters = array_diff($currentFilters, ['revisada']);
                }

                if (in_array($filter, $currentFilters)) {
                    $currentFilters = array_diff($currentFilters, [$filter]);
                } else {
                    $currentFilters[] = $filter;
                }
            }
        }

        $query = Ubicacion::find();

        $fechaDesde = $request->get('fecha_desde');
        $fechaHasta = $request->get('fecha_hasta');

        if ($fechaDesde && $fechaHasta) {
            $fechaDesdeObj = DateTime::createFromFormat('d/m/Y', $fechaDesde);
            $fechaHastaObj = DateTime::createFromFormat('d/m/Y', $fechaHasta);

            if ($fechaDesdeObj && $fechaHastaObj) {
                $fechaDesdeFormateada = $fechaDesdeObj->format('Y-m-d');
                $fechaHastaFormateada = $fechaHastaObj->format('Y-m-d');

                if ($fechaDesdeFormateada > $fechaHastaFormateada) {
                    Yii::$app->session->setFlash('error', 'La fecha "Desde" no puede ser mayor que la fecha "Hasta".');
                } else {
                    $query->andWhere(['between', 'DATE(ubicacion.fecha_creacion)', $fechaDesdeFormateada, $fechaHastaFormateada]);
                }
            } else {
                Yii::$app->session->setFlash('error', 'Formato de fecha inválido. Por favor, use DD/MM/YYYY.');
            }
        }

        if (in_array('libres', $currentFilters)) {
            $query->leftJoin('alertas', 'alertas.id_ubicacion = ubicacion.id')
                  ->andWhere(['IS', 'alertas.id_ubicacion', null]);
        }

        if (!in_array('todas', $currentFilters)) {
            if (in_array('revisada', $currentFilters)) {
                $query->andWhere(['ubicacion.is_revisada' => 1]);
            }
            if (in_array('no_revisada', $currentFilters)) {
                $query->andWhere(['ubicacion.is_revisada' => 0]);
            }
            if (in_array('nueva', $currentFilters)) {
                $fechaHace3Dias = date('Y-m-d H:i:s', strtotime('-3 days'));
                $query->andWhere(['>=', 'ubicacion.fecha_creacion', $fechaHace3Dias]);
            }
        }

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'fecha_creacion' => SORT_DESC,
                ],
            ],
        ]);

        return $this->render('libres', [
            'dataProvider' => $dataProvider,
            'currentFilters' => array_unique($currentFilters),
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
        ]);
    }
}
