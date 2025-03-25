<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

class UserController extends Controller
{
    /**
     * Behaviors for access control
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // Solo usuarios autenticados pueden acceder
                    ],
                ],
            ],
        ];
    }

    /**
     * Muestra la página del perfil del usuario.
     * @return string
     * @throws NotFoundHttpException si el usuario no está autenticado
     */
    public function actionProfile()
    {
        $user = Yii::$app->user->identity;
        $this->ensureUserExists($user);

        return $this->render('profile', [
            'user' => $user,
        ]);
    }

    /**
     * Editar perfil de usuario.
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException si el usuario no está autenticado
     */
    public function actionEdit()
    {
        $user = Yii::$app->user->identity;
        $this->ensureUserExists($user);

        if ($user->load(Yii::$app->request->post()) && $user->validate()) {
            if ($user->save()) {
                Yii::$app->session->setFlash('success', 'Perfil actualizado correctamente.');
                return $this->redirect(['profile']);
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo guardar los cambios. Inténtalo de nuevo.');
            }
        }

        return $this->render('edit', [
            'user' => $user,
        ]);
    }

    /**
     * Cambiar la contraseña del usuario.
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException si el usuario no está autenticado
     */
    public function actionChangePassword()
    {
        $user = Yii::$app->user->identity;
        $this->ensureUserExists($user);

        $user->scenario = 'changePassword';

        if ($user->load(Yii::$app->request->post()) && $user->validate()) {
            $user->setPassword($user->newPassword);
            if ($user->save(false)) {
                Yii::$app->session->setFlash('success', 'Contraseña cambiada con éxito.');
                return $this->redirect(['profile']);
            } else {
                Yii::$app->session->setFlash('error', 'No se pudo guardar la nueva contraseña. Inténtalo de nuevo.');
            }
        }

        return $this->render('change-password', [
            'user' => $user,
        ]);
    }

    /**
     * Eliminar cuenta de usuario.
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException si el usuario no está autenticado
     */
    public function actionEliminar()
    {
        $user = Yii::$app->user->identity;
        $this->ensureUserExists($user);

        if (Yii::$app->request->isPost) {
            $postData = Yii::$app->request->post('Usuario');

            if ($postData && isset($postData['eliminar_razon'])) {
                $user->eliminar_razon = $postData['eliminar_razon'];
                if ($user->save(false)) {
                    Yii::$app->user->logout();
                    return $this->redirect(['/site/login']);
                }
            } else {
                Yii::$app->session->setFlash('error', 'Debe proporcionar una razón para eliminar la cuenta.');
            }
        }

        return $this->render('eliminar', ['user' => $user]);
    }

    /**
     * Asegura que el usuario exista, de lo contrario lanza un error 404.
     * @param mixed $user
     * @throws NotFoundHttpException
     */
    protected function ensureUserExists($user)
    {
        if ($user === null) {
            throw new NotFoundHttpException('Usuario no encontrado.');
        }
    }
}
