<?php

namespace app\controllers;

use Yii;
use app\models\ModificarAlertas;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;

class ModificarAlertasController extends Controller
{
    // 列出当前用户的所有警报
    // 列出当前用户创建的所有警报
    public function actionListalerta()
    {
        $userId = Yii::$app->user->id; // 获取当前登录用户的 ID

        // 数据提供者，用于分页和排序
        $dataProvider = new ActiveDataProvider([
            'query' => ModificarAlertas::find()->where(['usuario_id' => $userId]),
            'pagination' => [
                'pageSize' => 10, // 每页显示 10 条数据
            ],
        ]);

        // 渲染视图
        return $this->render('//alert/listalerta', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionModificar($id)
    {
        // 调用私有方法查找模型
        $alerta = $this->findModel($id);

        // 检查是否属于当前用户
        if ($alerta->usuario_id !== Yii::$app->user->id) {
            throw new ForbiddenHttpException('No tienes permiso para modificar esta alerta.');
        }

        // 处理表单提交
        if ($alerta->load(Yii::$app->request->post()) && $alerta->save()) {
            Yii::$app->session->setFlash('success', '¡La alerta se ha actualizado correctamente!');
            return $this->redirect(['listalerta']); // 重定向到警报列表页面
        }

        // 渲染修改视图
        return $this->render('//alert/modificar', [
            'model' => $alerta,
        ]);
    }

    // 查找警报的私有方法
    protected function findModel($id)
    {
        if (($model = ModificarAlertas::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('La alerta no existe.');
    }
}

