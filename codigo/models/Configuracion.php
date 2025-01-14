<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Configuracion extends ActiveRecord
{
    public static function tableName()
    {
        return 'configuracion';
    }

    public function rules()
    {
        return [
            [['parametro', 'valor'], 'required'],
            [['parametro'], 'string', 'max' => 255],
            [['valor'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parametro' => 'Parámetro',
            'valor' => 'Valor',
        ];
    }
}