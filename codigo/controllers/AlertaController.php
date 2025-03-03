<?php

namespace app\controllers;

use Yii;
use app\models\Alerta;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class AlertaController extends Controller
{
    /**
     * Configuración de permisos según roles.
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['create', 'update', 'delete'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['@'], // Solo usuarios registrados pueden crear alertas
                    ],
                    [
                        'actions' => ['update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'], // Solo dueños de la alerta o admins pueden modificar o borrar
                        'matchCallback' => function ($rule, $action) {
                            $id = Yii::$app->request->get('id');
                            $alerta = Alerta::findOne($id);
                            return $alerta && ($alerta->id_usuario == Yii::$app->user->id || Yii::$app->user->identity->isAdmin);
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'], // La eliminación solo se permite con POST
                ],
            ],
        ];
    }

    /**
     * Muestra todas las alertas.
     */
    public function actionIndex($id_categoria = null)
    {
        $query = Alerta::find()->orderBy(['fecha_creacion' => SORT_DESC]);

        if ($id_categoria !== null) {
            $query->andWhere(['id_categoria' => $id_categoria]);
        }

        $alertas = $query->all();

        return $this->render('index', [
            'alertas' => $alertas,
        ]);
    }



    /**
     * Muestra el detalle de una alerta.
     */
    public function actionView($id)
    {
        $alerta = $this->findModel($id);
        return $this->render('view', ['alerta' => $alerta]);
    }

    /**
     * Crea una nueva alerta.
     */
    public function actionCreate()
    {
        $model = new Alerta();
        $model->id_usuario = Yii::$app->user->id; // Asigna al usuario actual

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Actualiza una alerta existente.
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    /**
     * Elimina una alerta existente.
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Encuentra el modelo Alerta basado en su clave primaria.
     */
    protected function findModel($id)
    {
        if (($model = Alerta::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('La alerta no existe.');
    }
}