<?php

namespace app\controllers;

use Yii;
use app\models\Imagen;
use app\models\ImagenSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class ImagenController extends Controller {

    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    public function actionIndex()
    {
        $searchModel = new ImagenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    public function actionCreate()
    {
        $model = new Imagen();
        $model->usuario_id = Yii::$app->user->id;
        $model->created_at = date('Y-m-d H:i:s');

        if ($this->request->isPost) {
            $model->load($this->request->post());
            $archivo = UploadedFile::getInstanceByName('archivo');

            if ($archivo && $model->validate()) {
                $alertaId = $model->alerta_id ?: 'sin-alerta';
                $usuarioId = Yii::$app->user->id;
                $fecha = date('Y-m-d');

                $basePath = Yii::getAlias('@webroot/images/uploads/');
                $rutaRelativa = "{$alertaId}/{$usuarioId}/{$fecha}/";
                $rutaCompleta = $basePath . $rutaRelativa;

                if (!file_exists($rutaCompleta)) {
                    mkdir($rutaCompleta, 0755, true);
                }

                $nombreUnico = Yii::$app->security->generateRandomString(16) . '.' . $archivo->extension;
                $rutaArchivo = $rutaRelativa . $nombreUnico;

                if ($archivo->saveAs($rutaCompleta . $nombreUnico)) {
                    $model->nombre = pathinfo($archivo->name, PATHINFO_FILENAME);
                    $model->ruta_archivo = $rutaArchivo;
                    $model->tam_img = $archivo->size;
                    $model->metadatos = $this->generarMetadatos($archivo);

                    if ($model->save()) {
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            }
        }

        return $this->render('create', ['model' => $model]);
    }

    private function generarMetadatos($archivo)
    {
        $metadatos = [
            'nombre_original' => $archivo->name,
            'tipo_mime' => $archivo->type,
            'tamano_bytes' => $archivo->size,
            'fecha_subida' => date('Y-m-d H:i:s')
        ];

        $infoImagen = @getimagesize($archivo->tempName);
        if ($infoImagen) {
            $metadatos['dimensiones'] = $infoImagen[0] . 'x' . $infoImagen[1];
            $metadatos['mime'] = $infoImagen['mime'];
        }

        return json_encode($metadatos, JSON_PRETTY_PRINT);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Imagen::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}