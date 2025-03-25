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
    $backupPath = Yii::getAlias('@app/backups');
    if (!is_dir($backupPath)) {
        mkdir($backupPath, 0777, true);
    }

    $fileName = 'backup_' . date('Ymd_His') . '.sql';
    $filePath = $backupPath . DIRECTORY_SEPARATOR . $fileName;

    $db = Yii::$app->db;
    $dsn = $db->dsn;
    preg_match('/dbname=([^;]*)/', $dsn, $matches);
    $dbName = $matches[1];
    preg_match('/host=([^;]*)/', $dsn, $hostMatches);
    $host = $hostMatches[1] ?? 'localhost';

    $username = escapeshellarg($db->username);
    $password = $db->password;
    $escapedFilePath = escapeshellarg($filePath);

    $mysqldumpPath = 'E:\\xampp\\mysql\\bin\\mysqldump.exe';

    // orden
    if ($password === '') {
        $command = "\"$mysqldumpPath\" -h$host -u$username $dbName > $escapedFilePath";
    } else {
        $command = "\"$mysqldumpPath\" -h$host -u$username -p$password $dbName > $escapedFilePath";
    }

    exec($command . ' 2>&1', $output, $resultCode); // 加上错误输出重定向

    if ($resultCode === 0 && filesize($filePath) > 10) {
        // exacto y no es vacio
        $backup = new \app\models\Backup();
        $backup->file_name = $fileName;
        $backup->save();
        Yii::$app->session->setFlash('success', '✅ éxito：' . $fileName);
    } else {
        Yii::$app->session->setFlash('error', '❌ fallo：' . implode("\n", $output));
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
