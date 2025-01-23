<?php

namespace app\models;

use yii\db\ActiveRecord;

class GestionAlerta extends ActiveRecord
{
    // Asignar la tabla de base de datos a este modelo
    public static function tableName()
    {
        return 'alertas'; // Nombre de la tabla
    }



    // Reglas de validación
    public function rules()
    {
        return [
            [['titulo', 'estado'], 'required'], // 必填字段
            [['descripcion'], 'string'], // 描述字段必须是字符串
            [['fecha_creacion', 'fecha_expiracion', 'completado_en'], 'safe'], // 时间字段安全
            [['estado'], 'in', 'range' => ['pendiente', 'completado']], // 限定状态值范围
            [['id_etiqueta'], 'integer'], // 标签 ID 必须是整数
        ];
    }


    // Etiquetas para los campos
    public function attributeLabels()
    {
        return [
            'id' => 'ID único para cada alerta',
            'titulo' => 'Título de la alerta',
            'descripcion' => 'Descripción de la alerta',
            'id_etiqueta' => 'ID de la etiqueta relacionada',
            'estado' => 'Estado de la alerta',
            'fecha_creacion' => 'Fecha de creación de la alerta',
            'fecha_expiracion' => 'Fecha de expiración de la alerta',
            'completado_en' => 'Fecha en la que se completó la alerta',
        ];
    }

}
