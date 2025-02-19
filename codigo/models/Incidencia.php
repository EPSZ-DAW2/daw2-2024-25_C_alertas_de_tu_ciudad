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
            [['descripcion', 'estado'], 'required'], // 必填字段
            [['descripcion'], 'string', 'max' => 255], // 描述限制为 255 字符以内
            [['estado'], 'in', 'range' => ['nueva', 'revisada', 'no revisada']], // 状态范围
            [['respuesta'], 'string'], // 确保 respuesta 是字符串类型
            [['creado_por', 'revisado_por'], 'integer'], // 创建者和审核者 ID 必须为整数
            [['fecha_creacion', 'fecha_revision'], 'safe'], // 时间字段
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
        ];
    }
}
