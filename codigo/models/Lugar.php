<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Lugar extends ActiveRecord
{
    public static function tableName()
    {
        return 'lugar';
    }

    public function rules()
    {
        return [
            [['direccion', 'area_id'], 'required'],
            [['direccion', 'notas'], 'string'],
            [['area_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'direccion' => 'Dirección',
            'notas' => 'Notas',
            'area_id' => 'Área',
        ];
    }

    public function getArea()
    {
        return $this->hasOne(Area::class, ['id' => 'area_id']);
    }

}