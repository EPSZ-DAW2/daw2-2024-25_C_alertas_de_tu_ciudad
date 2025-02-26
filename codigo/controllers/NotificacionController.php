<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Notificacion;
use yii\data\ActiveDataProvider;

class NotificacionController extends Controller
{
    /**
     * Lists all notifications.
     * @return string
     */
    public function actionIndex()
{
    $dataProvider = new \yii\data\ActiveDataProvider([
        'query' => Notificacion::find(),
        'pagination' => [
            'pageSize' => 10,  // 每页显示 10 条记录
        ],
    ]);

    return $this->render('index', [
        'dataProvider' => $dataProvider,
    ]);
}

public function actionDelete($id)
{
    $notificacion = Notificacion::findOne($id);
    if ($notificacion) {
        $notificacion->delete();
    }

    return $this->redirect(['notificacion/index']); // 删除后返回通知列表
}

}
