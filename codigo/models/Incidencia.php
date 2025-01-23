<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Incidencia extends ActiveRecord
{
    public static function tableName()
    {
        return 'incidencias'; // 表名
    }

    public function rules()
    {
        return [
            [['descripcion', 'creado_por'], 'required'],
            [['descripcion'], 'string'],
            [['estado'], 'in', 'range' => ['nueva', 'en proceso', 'resuelta']],
            [['fecha_revision'], 'safe'],
            [['creado_por', 'revisado_por'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripción',
            'estado' => 'Estado',
            'creado_por' => 'Creado Por',
            'fecha_creacion' => 'Fecha de Creación',
            'fecha_revision' => 'Fecha de Revisión',
            'revisado_por' => 'Revisado Por',
        ];
    }
}
