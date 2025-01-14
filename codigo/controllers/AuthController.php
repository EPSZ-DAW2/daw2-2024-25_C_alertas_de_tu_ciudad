<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Usuario;
use app\models\LoginForm;

class AuthController extends Controller
{
    public function actionRegistrar()
    {
        $model = new Usuario();

        if ($model->load(Yii::$app->request->post())) {
            $model->role = 'usuario';
            $model->password = $model->password1;
            $model->register_date = date('Y-m-d H:i:s');
            $model->confirmed = 1;

            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
                return $this->redirect(['auth/login']);
            } else {
                Yii::$app->session->setFlash('error', 'Error al registrar el usuario.');
            }
        } else {
            Yii::$app->session->setFlash('error', 'Error en el formulario.');
        }

        return $this->render('//site/registrar', ['model' => $model]);
    }




    public function actionLogin()
    {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect($this->getRedirectUrl(Yii::$app->user->identity->role));
        }

        return $this->render('//site/login', ['model' => $model]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(['site/index']);
    }

    private function getRedirectUrl($role)
    {
        switch ($role) {
            case 'usuario':
                return ['usuario/index'];
            case 'moderador':
                return ['moderador/index'];
            case 'administrador':
                return ['admin/index'];
            case 'sysadmin':
                return ['sysadmin/index'];
            default:
                return ['site/index'];
        }
    }
}
