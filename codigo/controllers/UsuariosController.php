<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\UsuarioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class UsuariosController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Usuario();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
{
    $model = $this->findModel($id);

    if ($model->load(Yii::$app->request->post()) && $model->save()) {
        Yii::$app->session->setFlash('success', 'Usuario actualizado correctamente.');
        return $this->redirect(['index']);
    }

    return $this->render('update', [
        'model' => $model,
    ]);
}

    protected function findModel($id)
    {
        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        }
    
        throw new NotFoundHttpException('El usuario solicitado no existe.');
    }
    

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionBloquear($id)
    {
        $model = $this->findModel($id);
        $model->is_locked = !$model->is_locked; // 切换锁定状态
    
        if ($model->save()) {
            Yii::$app->session->setFlash('success', $model->is_locked ? 'Usuario bloqueado.' : 'Usuario desbloqueado.');
        } else {
            Yii::$app->session->setFlash('error', 'No se pudo actualizar el estado de bloqueo.');
        }
    
        return $this->redirect(['index']);
    }
    
    public function actionLock($id)
{
    $user = $this->findModel($id);
    $user->is_locked = 1; // 设置为锁定状态

    if ($user->save(false)) { // 保存到数据库
        Yii::$app->session->setFlash('success', 'Usuario bloqueado exitosamente.');
    } else {
        Yii::$app->session->setFlash('error', 'No se pudo actualizar el estado de bloqueo.');
    }

    return $this->redirect(['index']);
}


public function actionUnlock($id)
{
    $user = $this->findModel($id);
    if ($user->unlock()) {
        Yii::$app->session->setFlash('success', 'Usuario desbloqueado exitosamente.');
    } else {
        Yii::$app->session->setFlash('error', 'No se pudo desbloquear al usuario.');
    }
    return $this->redirect(['index']);
}

}
