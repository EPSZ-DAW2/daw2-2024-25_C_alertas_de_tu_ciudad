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

        if (!is_array($currentFilters)) {
            $currentFilters = explode(',', $currentFilters);
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

        $query = Ubicacion::find()
            ->leftJoin('alertas', 'alertas.id_ubicacion = ubicacion.id')
            ->where(['alertas.id_ubicacion' => null]);

        if (!in_array('todas', $currentFilters)) {
            if (in_array('revisada', $currentFilters)) {
                $query->andWhere(['ubicacion.is_revisada' => true]);
            }
            if (in_array('no_revisada', $currentFilters)) {
                $query->andWhere(['ubicacion.is_revisada' => false]);
            }
            if (in_array('nueva', $currentFilters)) {
                $threeDaysAgo = date('Y-m-d H:i:s', strtotime('-3 days'));
                $query->andWhere(['>=', 'ubicacion.fecha_creacion', $threeDaysAgo]);
            }
        }

        return $this->render('libres', [
            'ubicacionesLibres' => $query->all(),
            'currentFilters' => array_unique($currentFilters),
        ]);
    }
}



