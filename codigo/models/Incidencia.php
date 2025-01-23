<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Clase modelo para la tabla 'incidencia'.
 * 手动定义模型与数据库交互
 */
class Incidencia extends ActiveRecord
{
    /**
     * Devuelve el nombre de la tabla asociada.
     * 指定数据库表名
     */
    public static function tableName()
    {
        return 'incidencia';
    }

    /**
     * Reglas de validación para los datos de la tabla.
     * 定义字段验证规则
     */
    public function rules()
    {
        return [
            [['titulo', 'estado'], 'required'], // 必填字段
            ['descripcion', 'string'], // 描述为字符串
            ['prioridad', 'in', 'range' => ['alta', 'media', 'baja']], // 优先级范围
            ['estado', 'in', 'range' => ['pendiente', 'procesada']], // 状态范围
            ['fecha_creacion', 'safe'], // 日期时间类型
        ];
    }

    /**
     * Etiquetas para los atributos.
     * 定义字段的标签名称
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título de la incidencia', // 事件标题
            'descripcion' => 'Descripción', // 事件描述
            'fecha_creacion' => 'Fecha de creación', // 创建时间
            'estado' => 'Estado', // 状态
            'prioridad' => 'Prioridad', // 优先级
        ];
    }
}
