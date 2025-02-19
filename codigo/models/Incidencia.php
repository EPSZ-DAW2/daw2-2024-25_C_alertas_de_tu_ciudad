<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
class Incidencia extends ActiveRecord
{
    public static function tableName()
    {
        return 'incidencia';
    }

    public function rules()
    {
        return [
            [['texto', 'id_usuario'], 'required'],
            [['texto'], 'string'],
            [['id_usuario', 'id_alerta', 'id_comentario'], 'integer'],
            [['fecha_lectura'], 'datetime'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'texto' => 'Texto',
            'id_usuario' => 'ID Usuario',
            'id_alerta' => 'ID Alerta',
            'id_comentario' => 'ID Comentario',
            'fecha_lectura' => 'Fecha de Lectura',
        ];
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'id_usuario']);
    }

    public function getAlerta()
    {
        return $this->hasOne(Alerta::class, ['id' => 'id_alerta']);
    }

    public function getComentario()
    {
        return $this->hasOne(Comentario::class, ['id' => 'id_comentario']);
    }
}