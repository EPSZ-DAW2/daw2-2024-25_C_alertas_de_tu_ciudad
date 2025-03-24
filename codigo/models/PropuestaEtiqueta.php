<?php

namespace app\models;

use yii\db\ActiveRecord;

class PropuestaEtiqueta extends ActiveRecord
{
    public static function tableName()
    {
        return 'propuesta_etiqueta';
    }

    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
            [['descripcion'], 'string'],
            [['usuario_id'], 'integer'],
            [['estado'], 'in', 'range' => ['pendiente', 'aprobado', 'rechazado']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
            'usuario_id' => 'Usuario',
            'estado' => 'Estado',
        ];
    }
}
