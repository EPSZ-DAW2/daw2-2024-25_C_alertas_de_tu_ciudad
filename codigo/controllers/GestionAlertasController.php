<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\GestionAlerta;

class GestionAlertasController extends Controller
{
    // Listar todas las alertas pendientes
    public function actionIndex()
    {
        // 获取所有未完成（pendiente）的警报
        $alertas = GestionAlerta::find()
            ->orderBy(['estado' => SORT_DESC, 'fecha_expiracion' => SORT_ASC]) // 按状态和过期时间排序
            ->all();


        // rendere view gestionarindex.php
        return $this->render('//alert/gestionarindex', ['alertas' => $alertas]);
    }


    // Marcar una alerta como completada
    // Marcar una alerta como completada
    public function actionCompletar($id)
    {
        // Buscar la alerta por ID
        $alerta = GestionAlerta::findOne($id);

        // Si no existe, lanzar excepción
        if (!$alerta) {
            throw new NotFoundHttpException('La alerta no existe.');
        }

        // Actualizar el estado y la fecha de completado
        $alerta->estado = 'completado';
        $alerta->completado_en = date('Y-m-d H:i:s'); // Establecer la fecha actual

        // Guardar los cambios
        if ($alerta->save()) {
            Yii::$app->session->setFlash('success', 'La alerta se completó exitosamente.');
        } else {
            Yii::$app->session->setFlash('error', 'No se pudo completar la alerta. Por favor, intente nuevamente.');
        }

        // Redirigir a la página de índice sin borrar los datos actuales
        return $this->redirect(['index']);
    }




    // Eliminar una alerta
    public function actionEliminar($id)
    {
        $alerta = GestionAlerta::findOne($id);
        if (!$alerta) {
            throw new NotFoundHttpException('La alerta no existe.');
        }

        if ($alerta->delete()) {
            Yii::$app->session->setFlash('success', 'La alerta se eliminó correctamente.');
        } else {
            Yii::$app->session->setFlash('error', 'No se pudo eliminar la alerta.');
        }

        return $this->redirect(['index']);
    }
}
