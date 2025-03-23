<?php

namespace app\controllers;

use Yii;
use app\models\Ubicacion;
use app\models\UbicacionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UbicacionController implements the CRUD actions for Ubicacion model.
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

        // Manejar el toggle de filtros
        if ($request->get('toggle')) {
            $filter = $request->get('toggle');

            if ($filter === 'todas') {
                $currentFilters = ['todas'];
            } else {
                // Si se selecciona un filtro, quitar 'todas'
                $currentFilters = array_diff($currentFilters, ['todas']);

                // Manejar exclusividad entre revisada y no_revisada
                if ($filter === 'revisada') {
                    $currentFilters = array_diff($currentFilters, ['no_revisada']);
                }
                if ($filter === 'no_revisada') {
                    $currentFilters = array_diff($currentFilters, ['revisada']);
                }

                // Toggle del filtro
                if (in_array($filter, $currentFilters)) {
                    $currentFilters = array_diff($currentFilters, [$filter]);
                } else {
                    $currentFilters[] = $filter;
                }
            }
        }

        // Consulta base
        $query = Ubicacion::find();

        // Aplicar filtro "libres" (ubicaciones sin alertas asociadas)
        if (in_array('libres', $currentFilters)) {
            $query->leftJoin('alertas', 'alertas.id_ubicacion = ubicacion.id')
                  ->andWhere(['IS', 'alertas.id_ubicacion', null]);
        }

        // Aplicar filtros adicionales
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

        // Configurar el dataProvider
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
        ]);
    }
}



