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
            [['estado'], 'string'], // 确保 estado 是字符串类型
            [['fecha_revision'], 'safe'], // fecha_revision 是日期时间类型
            [['respuesta'], 'safe'], // 确保 respuesta 字段可以验证和保存
            [['descripcion', 'estado'], 'required'], // 保留现有规则
            [['respuesta'], 'string'], // 新增 respuesta 的验证规则
            [['fecha_creacion', 'fecha_revision'], 'safe'],
            [['descripcion', 'estado'], 'required'], // 必填字段
            [['descripcion'], 'string', 'max' => 255],
            [['estado'], 'in', 'range' => ['nueva', 'revisada', 'no revisada']], 
           
            [['estado'], 'in', 'range' => ['nueva', 'revisada']], // 确保范围内有允许的值
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
            'respuesta' => 'Respuesta',
            'descripcion' => 'Descripción',
            'estado' => 'Estado',
            'fecha_creacion' => 'Fecha de Creación',
            'fecha_revision' => 'Fecha de Revisión',
        ];
    }
}
