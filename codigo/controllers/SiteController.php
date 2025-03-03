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
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex($ciudad = null)
    {
        $query = Alerta::find();

        if ($ciudad) {
            $query->where(['ubicacion' => $ciudad]);
        }

        $alertas = $query->all();

        return $this->render('index', [
            'alertas' => $alertas,
            'ciudad' => $ciudad
        ]);
    }

    /**
     * Muestra el árbol de categorías y sus alertas.
     *
     * @return string
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
     *
     * @return Response|string
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
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
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
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
