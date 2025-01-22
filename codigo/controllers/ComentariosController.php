<?php

namespace app\controllers;

use Yii;
use app\models\Comentario;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use app\models\Configuration; // 引入 Configuration 模型


class ComentariosController extends Controller
{
    public function actionIndex()
    {
        // 查询评论数据
        $query = Comentario::find();

        // 获取分页条数（从配置中动态读取）
        $paginationSize = Configuration::findOne(['key_name' => 'pagination_size'])->value;

        // 设置分页
        $pagination = new Pagination([
            'defaultPageSize' => $paginationSize, // 每页显示条数
            'totalCount' => $query->count(), // 获取评论总数
        ]);

        // 获取当前页的数据
        $comentarios = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        // 渲染视图，并传递分页数据
        return $this->render('index', [
            'comentarios' => $comentarios,
            'pagination' => $pagination,
        ]);
    }

    public function actionRevisarDenuncias()
    {
        // 查询被举报的评论
        $query = Comentario::find()->where(['es_denunciado' => 1]);

        // 获取分页条数（从配置中动态读取）
        $paginationSize = Configuration::findOne(['key_name' => 'pagination_size'])->value;

        // 设置分页
        $pagination = new Pagination([
            'defaultPageSize' => $paginationSize, // 每页显示条数
            'totalCount' => $query->count(), // 获取评论总数
        ]);

        // 获取当前页的数据
        $comentarios = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        // 渲染视图并传递数据
        return $this->render('revisar-denuncias', [
            'comentarios' => $comentarios,
            'pagination' => $pagination,
        ]);
    }

    public function actionBloquearHilo($id)
    {
        // Bloquea un hilo (invisible)
        $comentario = $this->findModel($id);
        $comentario->es_visible = 0;
        $comentario->save();
        return $this->redirect(['index']);
    }

    public function actionCerrarHilo($id)
    {
        // Cierra un hilo
        $comentario = $this->findModel($id);
        $comentario->es_cerrado = 1;
        $comentario->save();
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Comentario::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('El comentario no existe.');
    }

    public function actionDesbloquearHilo($id)
    {
        $comentario = $this->findModel($id);
        if ($comentario) {
            $comentario->es_visible = 1; // 设置为可见
            $comentario->save();
        }
        return $this->redirect(['index']);
    }

    public function actionReabrirHilo($id)
    {
        $comentario = $this->findModel($id);
        if ($comentario) {
            $comentario->es_cerrado = 0; // 设置为开放状态
            $comentario->save();
        }
        return $this->redirect(['index']);
    }



}
