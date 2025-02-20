<?php
namespace app\controllers;

use Yii;
use app\models\Usuario;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ControlUsuarioBloqueadosController extends Controller
{
    // Mostrar todos los usuarios
    public function actionIndex()
    {
        $users = Usuario::find()->all(); // Consultar a todos los usuarios
        return $this->render('//bloquearuser/index', [
            'users' => $users,
        ]);
    }

    // Bloquear usuario
    public function actionLock($id)
    {
        $user = Usuario::findOne($id);

        if ($user) {
            $user->locked = 1; // Establecer el usuario en estado prohibido
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Usuario bloqueado exitosamente！');
            } else {
                Yii::$app->session->setFlash('error', 'La prohibición falló, por favor intente nuevamente más tarde！');
            }
        } else {
            throw new NotFoundHttpException('El usuario no existe！');
        }

        return $this->redirect(['index']);
    }

    // Desbloquear usuario
    public function actionUnlock($id)
    {
        $user = Usuario::findOne($id);

        if ($user) {
            $user->locked = 0; // Establecer el usuario al estado normal
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Usuario desbloqueado exitosamente！');
            } else {
                Yii::$app->session->setFlash('error', 'El desbloqueo falló, inténtelo nuevamente más tarde！');
            }
        } else {
            throw new NotFoundHttpException('El usuario no existe！');
        }

        return $this->redirect(['index']);
    }
}
