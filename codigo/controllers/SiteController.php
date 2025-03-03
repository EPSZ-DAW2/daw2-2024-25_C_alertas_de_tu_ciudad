<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Categoria;
use app\models\Alerta;
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
        $session = Yii::$app->session;

        if (Yii::$app->request->get('borrarFiltro')) {
            $session->remove('ciudad');
            $ciudad = null;
        } elseif ($ciudad) {
            $session->set('ciudad', $ciudad);
        } elseif ($session->has('ciudad')) {
            $ciudad = $session->get('ciudad');
        }

        $query = Alerta::find()->joinWith('ubicacion');

        if ($ciudad) {
            $ciudadUpper = mb_strtoupper($ciudad, 'UTF-8');

            // Obtener todas las ubicaciones de una vez
            $todasUbicaciones = Ubicacion::find()->asArray()->all();

            // Mapear ubicaciones por ID y padre
            $mapaHijos = [];
            $ubicacionId = null;
            foreach ($todasUbicaciones as $u) {
                if (mb_strtoupper($u['nombre'], 'UTF-8') === $ciudadUpper) {
                    $ubicacionId = $u['id'];
                }
                $mapaHijos[$u['ub_code_padre']][] = $u['id'];
            }

            if ($ubicacionId !== null) {
                // Obtener descendientes en memoria
                $idsUbicaciones = $this->obtenerDescendientesMemoria($ubicacionId, $mapaHijos);
                $idsUbicaciones[] = $ubicacionId;

                $query->andWhere(['ubicacion.id' => $idsUbicaciones]);
            } else {
                $query->andWhere('0=1');
            }
        }

        $alertas = $query->all();

        return $this->render('index', [
            'alertas' => $alertas,
            'ciudad' => $ciudad,
        ]);
    }

    /**
     * Función optimizada para obtener IDs de descendientes en memoria
     */
    private function obtenerDescendientesMemoria($idPadre, &$mapaHijos)
    {
        $ids = [];

        if (isset($mapaHijos[$idPadre])) {
            foreach ($mapaHijos[$idPadre] as $hijoId) {
                $ids[] = $hijoId;
                // Llamada recursiva en memoria
                $ids = array_merge($ids, $this->obtenerDescendientesMemoria($hijoId, $mapaHijos));
            }
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
                'nombre' => mb_strtoupper($ubicacion->nombre, 'UTF-8'),
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
    public function actionCategorias($id_categoria = null)
    {
        $categorias = \app\models\Categoria::find()->all();
        $alertas = [];

        if ($id_categoria !== null) {
            $alertas = \app\models\Alerta::find()
                ->where(['id_categoria' => $id_categoria])
                ->all();
        }

        return $this->render('categorias', [
            'categorias' => $categorias,
            'alertas' => $alertas,
            'categoriaSeleccionada' => $id_categoria,
        ]);
    }

    /**
     * Muestra las etiquetas y las alertas asociadas a una etiqueta específica.
     *
     * @return string
     */
    public function actionEtiquetas($id_etiqueta = null)
    {
        $etiquetas = \app\models\Etiqueta::find()->all();
        $alertas = [];

        if ($id_etiqueta !== null) {
            $alertas = \app\models\Alerta::find()
                ->where(['id_etiqueta' => $id_etiqueta])
                ->all();
        }

        return $this->render('etiquetas', [
            'etiquetas' => $etiquetas,
            'alertas' => $alertas,
            'etiquetaSeleccionada' => $id_etiqueta,
        ]);
    }



    /**
     * Login action.
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
