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

    public function actions()
    {
        return [
            'error'   => ['class' => 'yii\web\ErrorAction'],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Acción principal que muestra alertas con filtros opcionales por ciudad
     * @param string|null $ciudad Nombre de ciudad para filtrar
     * @param bool|null $borrarFiltro Bandera para limpiar filtros actuales
     * @return string Vista renderizada con alertas y ubicaciones
     */
    public function actionIndex($ciudad = null, $borrarFiltro = null)
    {
        if ($borrarFiltro) {
            return $this->redirect(['site/index']);
        }

        $query = Alerta::find()->joinWith('ubicacion');
        $searchParams = Yii::$app->request->get();
        $this->aplicarFiltrosBusqueda($query, $searchParams);

        if ($ciudad) {
            $ubicaciones = $this->aplicarFiltroUbicacion($query, $ciudad);
        } else {
            $ubicaciones = Ubicacion::find()
                ->select(['nombre', 'latitud', 'longitud'])
                ->where(['not', ['latitud' => null]])
                ->andWhere(['not', ['longitud' => null]])
                ->asArray()
                ->all();
        }

        return $this->render('index', [
            'alertas'      => $query->all(),
            'ciudad'       => $ciudad,
            'ubicaciones'  => $ubicaciones,
            'searchParams' => $searchParams
        ]);
    }

    /**
     * Acción de búsqueda de alertas por ubicación
     * @param int|null $ubicacion ID de ubicación para filtrar
     * @return string Vista renderizada con resultados de búsqueda
     */
    public function actionBusqueda($ubicacion = null)
    {
        if ($ubicacion) {
            Yii::$app->session->set('ubicacion', $ubicacion);
        } else {
            $ubicacion = Yii::$app->session->get('ubicacion');
        }

        $query = Alerta::find();
        if ($ubicacion) {
            $query->where(['ubicacion_id' => $ubicacion]);
        }

        return $this->render('busqueda', [
            'alertas'      => $query->all(),
            'ubicaciones'  => Ubicacion::find()->asArray()->all(),
            'ubicacion'    => $ubicacion,
        ]);
    }

    /**
     * Endpoint AJAX para búsqueda de ubicaciones
     * @param string|null $q Término de búsqueda
     * @return array Resultados en formato JSON
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

        return array_map(function($ubicacion) {
            return [
                'nombre' => $ubicacion->nombre,
                'padre'  => $ubicacion->ubCodePadre ? $ubicacion->ubCodePadre->nombre : '',
            ];
        }, $ubicaciones);
    }

    /**
     * Muestra alertas filtradas por categoría
     * @param int|null $id_categoria ID de categoría para filtrar
     * @return string Vista renderizada con alertas por categoría
     */
    public function actionCategorias($id_categoria = null)
    {
        $alertas = $id_categoria ? Alerta::find()->where(['id_categoria' => $id_categoria])->all() : [];

        return $this->render('categorias', [
            'categorias'           => Categoria::find()->all(),
            'alertas'              => $alertas,
            'categoriaSeleccionada'=> $id_categoria,
        ]);
    }

    /**
     * Muestra alertas filtradas por etiqueta
     * @param int|null $id_etiqueta ID de etiqueta para filtrar
     * @return string Vista renderizada con alertas por etiqueta
     */
    public function actionEtiquetas($id_etiqueta = null)
    {
        $alertas = $id_etiqueta ? Alerta::find()->where(['id_etiqueta' => $id_etiqueta])->all() : [];

        return $this->render('etiquetas', [
            'etiquetas'           => \app\models\Etiqueta::find()->all(),
            'alertas'             => $alertas,
            'etiquetaSeleccionada'=> $id_etiqueta,
        ]);
    }

    /**
     * Acción para el formulario de login
     * @return mixed Redirección o vista de login
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
        return $this->render('login', ['model' => $model]);
    }

    /**
     * Acción para cerrar sesión
     * @return mixed Redirección al home
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    /**
     * Acción para el formulario de contacto
     * @return string Vista renderizada del formulario
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', ['model' => $model]);
    }

    /**
     * Acción para la página "Acerca de"
     * @return string Vista renderizada
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Aplica filtros de búsqueda incluyendo rango de fechas
     * @param \yii\db\ActiveQuery $query Consulta a modificar
     * @param array $params Parámetros de búsqueda
     */
    private function aplicarFiltrosBusqueda($query, $params) {

        if (!empty($params['titulo'])) {
            $query->andFilterWhere(['like', 'alertas.titulo', $params['titulo']]);
        }
        if (!empty($params['descripcion'])) {
            $query->andFilterWhere(['like', 'alertas.descripcion', $params['descripcion']]);
        }
        if (!empty($params['id_categoria'])) {
            $query->andFilterWhere(['alertas.id_categoria' => $params['id_categoria']]);
        }
        if (!empty($params['id_etiqueta'])) {
            $query->andFilterWhere(['alertas.id_etiqueta' => $params['id_etiqueta']]);
        }
        $tieneFechaDesde = !empty($params['fecha_desde']);
            $tieneFechaHasta = !empty($params['fecha_hasta']);

            if ($tieneFechaDesde || $tieneFechaHasta) {
                $fechaDesde = $tieneFechaDesde ? $this->formatearFecha($params['fecha_desde'], '00:00:00') : null;
                $fechaHasta = $tieneFechaHasta ? $this->formatearFecha($params['fecha_hasta'], '23:59:59') : null;

                Yii::debug("Fecha desde formateada: " . $fechaDesde);
                Yii::debug("Fecha hasta formateada: " . $fechaHasta);

                if ($fechaDesde === false || $fechaHasta === false) {
                    Yii::$app->session->setFlash('error', 'Formato de fecha incorrecto. Usa dd/mm/aaaa');
                    return $query;
                }

                if ($tieneFechaDesde && $tieneFechaHasta) {
                    $query->andWhere(['between', 'alertas.fecha_creacion', $fechaDesde, $fechaHasta]);
                } elseif ($tieneFechaDesde) {
                    $query->andWhere(['>=', 'alertas.fecha_creacion', $fechaDesde]);
                } elseif ($tieneFechaHasta) {
                    $query->andWhere(['<=', 'alertas.fecha_creacion', $fechaHasta]);
                }
            }

        $this->aplicarFiltrosUbicacion($query, $params);
    }

    /**
     * Convierte fecha de formato dd/mm/YYYY a YYYY-mm-dd para la base de datos
     * @param string $fecha Fecha en formato dd/mm/YYYY
     * @param string $hora Hora a concatenar
     * @return string|false Fecha en formato YYYY-mm-dd H:i:s o false si es inválida
     */
    private function formatearFecha($fecha, $hora = '') {
        $fecha = trim($fecha);

        if (empty($fecha)) {
            return false;
        }

        if (!preg_match('/^\d{1,2}[\/-]\d{1,2}[\/-]\d{4}$/', $fecha)) {
            Yii::error("Formato de fecha inválido (debe ser dd/mm/aaaa): " . $fecha);
            return false;
        }

        $separator = strpos($fecha, '/') !== false ? '/' : '-';
        $partes = explode($separator, $fecha);

        if (count($partes) !== 3) {
            return false;
        }

        $dia = $partes[0];
        $mes = $partes[1];
        $anio = $partes[2];

        if (!checkdate($mes, $dia, $anio)) {
            Yii::error("Fecha no válida: " . $fecha);
            return false;
        }

        return sprintf('%04d-%02d-%02d%s', $anio, $mes, $dia, $hora ? ' ' . ltrim($hora) : '');
    }

    /**
     * Aplica filtros de ubicación jerárquica a la consulta
     * @param \yii\db\ActiveQuery $query Consulta a modificar
     * @param array $params Parámetros de búsqueda
     */
    private function aplicarFiltrosUbicacion($query, $params)
    {
        $niveles = [
            'continente' => 1,
            'pais'       => 2,
            'comunidad'  => 3,
            'provincia'  => 4,
            'localidad'  => 6,
            'barrio'     => 7
        ];

        $nivelesInvertidos = array_reverse($niveles, true);
        foreach ($nivelesInvertidos as $paramName => $ubCode) {
            if (!empty($params[$paramName])) {
                $ubicacion = Ubicacion::find()
                    ->where(['nombre' => $params[$paramName], 'ub_code' => $ubCode])
                    ->one();
                if ($ubicacion) {
                    $ubicacionIds = $this->obtenerUbicacionesJerarquia($ubicacion->id);
                    $query->andWhere(['alertas.id_ubicacion' => $ubicacionIds]);
                    break;
                }
            }
        }
    }

    /**
     * Obtiene recursivamente todos los IDs de ubicaciones descendientes
     * @param int $idUbicacion ID de ubicación padre
     * @return array IDs de todas las ubicaciones hijas
     */
    private function obtenerUbicacionesJerarquia($idUbicacion)
    {
        $ids = [$idUbicacion];
        $descendientes = Ubicacion::find()->where(['ub_code_padre' => $idUbicacion])->all();
        foreach ($descendientes as $desc) {
            $ids = array_merge($ids, $this->obtenerUbicacionesJerarquia($desc->id));
        }
        return $ids;
    }

    /**
     * Aplica filtro por ubicación basado en nombre de ciudad
     * @param \yii\db\ActiveQuery $query Consulta a modificar
     * @param string $ciudad Nombre de la ciudad
     * @return array Ubicaciones encontradas
     */
    private function aplicarFiltroUbicacion($query, $ciudad)
    {
        $ubicacion = Ubicacion::find()->where(['nombre' => $ciudad])->one();
        if ($ubicacion) {
            $ubicacionIds = $this->obtenerUbicacionesJerarquia($ubicacion->id);
            $query->andWhere(['alertas.id_ubicacion' => $ubicacionIds]);
        }
        return Ubicacion::find()
            ->select(['nombre', 'latitud', 'longitud'])
            ->where(['nombre' => $ciudad])
            ->andWhere(['not', ['latitud' => null]])
            ->andWhere(['not', ['longitud' => null]])
            ->asArray()
            ->all();
    }
}