<?php
namespace app\controllers;

use Yii;
use app\models\Incidencia;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ControlIncidenciasController extends Controller
{
    /**
     * Muestra la lista de incidencias pendientes.
     * 显示未处理事件列表
     */
    public function actionIndex()
    {
        $incidencias = Incidencia::find()->where(['estado' => 'pendiente'])->all();
        return $this->render('//controlincidencia/index', ['incidencias' => $incidencias]);
    }

    /**
     * Marca una incidencia como procesada.
     * 将事件标记为已处理
     */
    public function actionProcesar($id)
    {
        $incidencia = Incidencia::findOne($id);

        if (!$incidencia) {
            throw new NotFoundHttpException('La incidencia no existe.'); // 事件不存在
        }

        $incidencia->estado = 'procesada'; // 更新事件状态为“已处理”
        if ($incidencia->save()) {
            Yii::$app->session->setFlash('success', '¡La incidencia se ha procesado con éxito!'); // 操作成功提示
        } else {
            Yii::$app->session->setFlash('error', 'Hubo un error al procesar la incidencia.'); // 操作失败提示
        }

        return $this->redirect(['index']); // 重定向回列表页面
    }
}
