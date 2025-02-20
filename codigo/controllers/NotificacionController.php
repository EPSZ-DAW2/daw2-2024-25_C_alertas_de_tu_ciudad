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
        $dataProvider = new ActiveDataProvider([
            'query' => Notificacion::find(),
            'pagination' => [
                'pageSize' => 10,  // 每页显示 10 条记录
            ],
            'sort' => [
                'defaultOrder' => [
                    'fecha' => SORT_DESC,  // 默认按日期降序排序
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
