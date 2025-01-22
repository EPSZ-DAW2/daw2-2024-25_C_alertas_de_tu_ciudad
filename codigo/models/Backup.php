<?php

namespace app\models;

use yii\db\ActiveRecord;

class Backup extends ActiveRecord
{
    // Especificar la tabla asociada al modelo
    public static function tableName()
    {
        return 'backups'; // Nombre de la tabla
    }

    // Reglas de validación para los campos
    public function rules()
    {
        return [
            [['file_name'], 'required'], // El nombre del archivo es obligatorio
            [['file_name'], 'string', 'max' => 255], // Longitud máxima de 255 caracteres
            [['created_at'], 'safe'], // Campo de fecha
        ];
    }
}
