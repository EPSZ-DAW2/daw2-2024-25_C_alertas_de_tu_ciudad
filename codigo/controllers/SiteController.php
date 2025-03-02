<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Alerta;
use app\models\Categoria;
use app\models\Ubicacion;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage with optional city filter.
     *
     * @param string|null $ciudad City name to filter alerts.
     * @return string Rendered homepage view.
     */
    public function actionIndex($ciudad = null)
    {
        // Manejo de sesiones
        if (Yii::$app->request->get('borrarFiltro')) {
            Yii::$app->session->remove('ciudad');
            $ciudad = null;
        } elseif ($ciudad = Yii::$app->request->get('ciudad')) {
            Yii::$app->session->set('ciudad', $ciudad);
        } else {
            $ciudad = Yii::$app->session->get('ciudad');
        }

        // Consulta de alertas
        $query = Alerta::find()->joinWith('ubicacion');

        if ($ciudad) {
            $ciudadUpper = mb_strtoupper($ciudad, 'UTF-8');

            // Obtener la ubicación principal
            $ubicacionPrincipal = Ubicacion::find()
                ->where(['like', 'nombre', $ciudadUpper])
                ->one();

            if ($ubicacionPrincipal) {
                // Obtener IDs de ubicaciones descendientes
                $idsUbicaciones = $this->obtenerDescendientes($ubicacionPrincipal->id);
                $idsUbicaciones[] = $ubicacionPrincipal->id; // Incluir la ubicación principal

                // Filtrar alertas por ubicaciones
                $query->andWhere(['ubicacion.id' => $idsUbicaciones]);

                // Obtener ubicaciones para el mapa (incluyendo las hijas)
                $ubicaciones = Ubicacion::find()
                    ->select(['nombre', 'latitud', 'longitud'])
                    ->where(['id' => $idsUbicaciones])
                    ->andWhere(['not', ['latitud' => null, 'longitud' => null]])
                    ->asArray()
                    ->all();
            } else {
                $query->andWhere('0=1'); // No hay resultados
                $ubicaciones = []; // No hay ubicaciones para el mapa
            }
        } else {
            // Si no hay filtro, obtener todas las ubicaciones con coordenadas
            $ubicaciones = Ubicacion::find()
                ->select(['nombre', 'latitud', 'longitud'])
                ->where(['not', ['latitud' => null, 'longitud' => null]])
                ->asArray()
                ->all();
        }

        $alertas = $query->all();

        return $this->render('index', [
            'alertas' => $alertas,
            'ciudad' => $ciudad,
            'ubicaciones' => $ubicaciones, // Pasar las ubicaciones al mapa
        ]);
    }

    /**
     * Función recursiva para obtener IDs de ubicaciones descendientes.
     *
     * @param int $idPadre ID de la ubicación padre.
     * @return array IDs de las ubicaciones descendientes.
     */
    private function obtenerDescendientes($idPadre)
    {
        $ids = [];
        $ubicacionesHijas = Ubicacion::find()
            ->where(['ub_code_padre' => $idPadre])
            ->all();

        foreach ($ubicacionesHijas as $ubicacion) {
            $ids[] = $ubicacion->id;
            $ids = array_merge($ids, $this->obtenerDescendientes($ubicacion->id));
        }

        return $ids;
    }

    /**
     * Returns matching locations as JSON for autocomplete.
     *
     * @param string|null $q Query string for searching locations.
     * @return array JSON array of matching locations.
     */
    public function actionBuscarUbicacion($q = null)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (empty($q)) {
            return [];
        }

        $ubicaciones = Ubicacion::find()
            ->with('ubCodePadre')
            ->where(['like', 'ubicacion.nombre', $q])
            ->limit(10)
            ->all();

        $resultado = [];
        foreach ($ubicaciones as $ubicacion) {
            $resultado[] = [
                'nombre' => $ubicacion->nombre,
                'padre' => $ubicacion->ubCodePadre ? $ubicacion->ubCodePadre->nombre : 'Sin padre',
            ];
        }

        return $resultado;
    }

    /**
     * Displays categories tree and related alerts.
     *
     * @return string Rendered categories view.
     */
    public function actionCategorias()
    {
        $categorias = Categoria::find()->all();
        return $this->render('categorias', ['categorias' => $categorias]);
    }

    /**
     * Handles user login.
     *
     * @return Response|string Redirect or rendered login view.
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logs out the current user.
     *
     * @return Response Redirects to homepage.
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Displays contact form and handles submissions.
     *
     * @return Response|string Rendered contact form or refreshed page on successful submission.
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string Rendered about view.
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}