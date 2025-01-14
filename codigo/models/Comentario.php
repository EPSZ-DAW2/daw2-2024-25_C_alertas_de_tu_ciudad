<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Comentario extends ActiveRecord
{
    public static function tableName()
    {
        return 'comentario';
    }

    public function rules()
    {
        return [
            [['texto', 'id_alerta', 'id_usuario'], 'required'],
            [['texto'], 'string'],
            [['id_alerta', 'id_usuario', 'estado_cierre', 'num_denuncias'], 'integer'],
            [['bloqueado'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'texto' => 'Texto',
            'id_alerta' => 'ID Alerta',
            'id_usuario' => 'ID Usuario',
            'estado_cierre' => 'Estado de Cierre',
            'num_denuncias' => 'Número de Denuncias',
            'bloqueado' => 'Bloqueado',
        ];
    }

    public function getAlerta()
    {
        return $this->hasOne(Alerta::class, ['id' => 'id_alerta']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'id_usuario']);
    }
}