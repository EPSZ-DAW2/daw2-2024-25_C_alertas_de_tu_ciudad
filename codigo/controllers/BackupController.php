<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Backup;

class BackupController extends Controller
{
    // Lista todos los respaldos
    public function actionIndex()
    {
        $backups = Backup::find()->all(); // Obtiene todos los respaldos
        return $this->render('index', ['backups' => $backups]);
    }

    // Crea un respaldo de la base de datos
    public function actionCreate()
    {
        $backupPath = Yii::getAlias('@app/backups'); // Ruta de la carpeta para respaldos
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0777, true); // Crea la carpeta si no existe
        }

        $fileName = 'backup_' . date('Ymd_His') . '.sql'; // Nombre del archivo
        $filePath = $backupPath . DIRECTORY_SEPARATOR . $fileName;

        // Ejecuta el comando mysqldump
        $db = Yii::$app->db;
        $dsn = $db->dsn;
        preg_match('/dbname=([^;]*)/', $dsn, $matches);
        $dbName = $matches[1];
        $username = $db->username;
        $password = $db->password;
        $host = preg_replace('/^.+host=([^;]+).+$/', '$1', $dsn);

        $command = "mysqldump -h$host -u$username -p$password $dbName > $filePath";
        system($command, $output);

        if (file_exists($filePath)) {
            // Guarda el registro del respaldo en la base de datos
            $backup = new Backup();
            $backup->file_name = $fileName;
            $backup->save();

            Yii::$app->session->setFlash('success', 'El respaldo se creó correctamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Error al crear el respaldo.');
        }

        return $this->redirect(['index']);
    }

    // Restaura la base de datos desde un respaldo
    public function actionRestore($id)
    {
        $backup = Backup::findOne($id);
        if (!$backup) {
            throw new NotFoundHttpException('El respaldo no existe.');
        }

        $backupPath = Yii::getAlias('@app/backups') . DIRECTORY_SEPARATOR . $backup->file_name;

        // Ejecuta el comando de restauración
        $db = Yii::$app->db;
        $dsn = $db->dsn;
        preg_match('/dbname=([^;]*)/', $dsn, $matches);
        $dbName = $matches[1];
        $username = $db->username;
        $password = $db->password;
        $host = preg_replace('/^.+host=([^;]+).+$/', '$1', $dsn);

        $command = "mysql -h$host -u$username -p$password $dbName < $backupPath";
        system($command, $output);

        Yii::$app->session->setFlash('success', 'La base de datos se restauró correctamente.');
        return $this->redirect(['index']);
    }
}
