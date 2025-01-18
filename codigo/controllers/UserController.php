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
        // 获取当前登录用户
        $user = Yii::$app->user->identity;
    
        // 确保用户存在
        if ($user === null) {
            throw new NotFoundHttpException('User not found.');
        }
    
        // 如果是 POST 请求，加载数据并验证
        if ($user->load(Yii::$app->request->post())) {
            if ($user->validate() && $user->save()) {
                // 保存成功，设置成功消息并重定向
                Yii::$app->session->setFlash('success', 'Profile updated successfully.');
                return $this->redirect(['profile']);
            } else {
                // 验证失败，设置错误消息
                Yii::$app->session->setFlash('error', 'Failed to update profile. Please check your inputs.');
            }
        }
    
        // 渲染编辑视图
        return $this->render('edit', [
            'user' => $user,
        ]);
    }
    
    /**
     * Handles not found users
     * This helper function ensures we handle missing users cleanly.
     * @return void
     * @throws NotFoundHttpException
     */
    protected function ensureUserExists($user)
    {
        if ($user === null) {
            throw new NotFoundHttpException('User not found.');
        }
    }
}
