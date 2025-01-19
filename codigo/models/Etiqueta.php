<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Etiqueta extends ActiveRecord
{
    public static function tableName()
    {
        return 'etiqueta';
    }

    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
        ];
    }

    public function getAlertas()
    {
        return $this->hasMany(Alerta::class, ['id' => 'id_alerta'])
            ->viaTable('alerta_etiqueta', ['id_etiqueta' => 'id']);
    }
}