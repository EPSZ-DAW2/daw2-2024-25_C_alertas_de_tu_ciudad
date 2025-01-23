<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ControlUsuarioNoConfirController extends Controller
{
    // 显示未确认用户列表
    public function actionIndex()
    {
        $users = Usuario::find()->where(['status' => 0])->all(); // 筛选 status = 0 的用户
        return $this->render('//controluser/index', ['users' => $users]);
    }

    // 手动确认用户
    public function actionConfirm($id)
    {
        $user = Usuario::findOne($id);

        if (!$user) {
            throw new NotFoundHttpException('El usuario no existe！');
        }

        if (Yii::$app->request->isPost) {
            Yii::debug(Yii::$app->request->post(), __METHOD__); // 调试 POST 数据

            if ($user->load(Yii::$app->request->post()) && $user->validate()) {
                $user->status = 1; // 修改状态为已确认
                if ($user->save()) {
                    Yii::$app->session->setFlash('success', 'Usuario confirmado exitosamente！');
                    return $this->redirect(['index']);
                } else {
                    Yii::error($user->errors, __METHOD__); // 调试保存错误
                    Yii::$app->session->setFlash('error', 'No se pudieron guardar los datos del usuario, inténtelo nuevamente más tarde！');
                }
            } else {
                Yii::error($user->errors, __METHOD__); // 调试验证错误
                Yii::$app->session->setFlash('error', 'Por favor, introduzca un número de teléfono válido！');
            }
        }

        return $this->render('//controluser/confirm', [
            'user' => $user,
        ]);
    }


    // Eliminar usuarios no confirmados
    public function actionDelete($id)
    {
        $user = Usuario::findOne($id);

        if (!$user) {
            throw new NotFoundHttpException('El usuario no existe！');
        }

        $user->delete(); // eliminar usuario
        Yii::$app->session->setFlash('success', 'Usuario eliminado exitosamente！');
        return $this->redirect(['index']);
    }
}
