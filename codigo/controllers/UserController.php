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
                        'roles' => ['@'], // Only authenticated users can access
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays the user profile page.
     * @return string
     * @throws NotFoundHttpException if the user is not logged in
     */
    public function actionProfile()
    {
        // Get the currently logged-in user
        $user = Yii::$app->user->identity;

        // Check if the user is logged in
        if ($user === null) {
            throw new NotFoundHttpException('User not found.');
        }

        // Render the profile view
        return $this->render('profile', [
            'user' => $user,
        ]);
    }

    /**
     * Edit user profile
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the user is not logged in
     */
    public function actionEdit()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new NotFoundHttpException('Usuario no encontrado.');
        }

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
     * Change user password
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the user is not logged in
     */
    public function actionChangePassword()
    {
        $user = Yii::$app->user->identity;

        if (!$user) {
            throw new NotFoundHttpException('El usuario no está autenticado.');
        }

       
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
     * Handles not found users
     * This helper function ensures we handle missing users cleanly.
     * @param mixed $user
     * @throws NotFoundHttpException
     */
    protected function ensureUserExists($user)
    {
        if ($user === null) {
            throw new NotFoundHttpException('User not found.');
        }
    }


    public function actionEliminar()
{
    $user = Yii::$app->user->identity;

    if ($user && Yii::$app->request->isPost) {
        $postData = Yii::$app->request->post('Usuario'); // 获取完整的 `Usuario` 表单数据
        
        if ($postData && isset($postData['eliminar_razon'])) {
            $user->eliminar_razon = $postData['eliminar_razon']; // 赋值删除原因
            if ($user->save(false)) { // 保存不进行验证
                Yii::$app->user->logout(); // 退出登录
                return $this->redirect(['/site/login']); // 重定向到登录页面
            }
        } else {
            Yii::$app->session->setFlash('error', 'Debe proporcionar una razón para eliminar la cuenta.');
        }
    }

    return $this->render('eliminar', ['user' => $user]);
}

}
