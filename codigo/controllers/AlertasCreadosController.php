<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\models\Alertascreados;

class AlertascreadosController extends Controller {

    public function actionIndex() {
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => Alertascreados::find(),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 删除记录操作
     */
    public function actionDelete($id) {
        $alerta = Alertascreados::findOne($id);
        if (!$alerta) {
            throw new NotFoundHttpException('Registro no encontrado.');
        }

        $alerta->delete();

        // 删除成功后跳转到 index 页
        return $this->redirect(['index']);
    }
}
