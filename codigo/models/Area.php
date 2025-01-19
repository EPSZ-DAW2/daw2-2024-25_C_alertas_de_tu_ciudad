<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Area extends ActiveRecord
{
    public static function tableName()
    {
        return 'area';
    }

    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
            [['parent_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'parent_id' => 'Área Superior',
        ];
    }

    public function getParent()
    {
        return $this->hasOne(Area::class, ['id' => 'parent_id']);
    }

    public function getChildren()
    {
        return $this->hasMany(Area::class, ['parent_id' => 'id']);
    }
}