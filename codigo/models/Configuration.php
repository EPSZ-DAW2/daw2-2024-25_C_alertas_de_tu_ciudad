<?php

namespace app\models;

use yii\db\ActiveRecord;

class Configuration extends ActiveRecord
{
    // Especificar la tabla asociada al modelo
    public static function tableName()
    {
        return 'configurations';
    }

    // Reglas de validación para los campos
    public function rules()
    {
        return [
            [['key_name', 'value'], 'required'], // Campos obligatorios
            [['key_name'], 'string', 'max' => 100], // Longitud máxima para key_name
            [['value', 'description'], 'string'], // Campos de tipo texto
            [['created_at', 'updated_at'], 'safe'], // Campos de fecha
        ];
    }

    // Etiquetas para los campos (usadas en formularios)
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key_name' => 'Clave',
            'value' => 'Valor',
            'description' => 'Descripción',
            'created_at' => 'Fecha de Creación',
            'updated_at' => 'Fecha de Actualización',
        ];
    }
}
