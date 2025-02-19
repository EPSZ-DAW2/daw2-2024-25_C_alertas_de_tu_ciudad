<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class AlertasCreados extends ActiveRecord {

    /**
     * 定义表名
     */
    public static function tableName() {
        return 'Alertas_Creados';
    }

    /**
     * 验证规则
     */
    public function rules() {
        return [
            [['Titulo', 'Descripcion'], 'required'],
            ['Descripcion', 'string'],
            ['FechaVencimiento', 'safe'],
            ['Acciones', 'string', 'max' => 255],
        ];
    }

    /**
     * 字段标签
     */
    public function attributeLabels() {
        return [
            'ID' => 'ID',
            'Titulo' => 'Título',
            'Descripcion' => 'Descripción',
            'FechaVencimiento' => 'Fecha_de_Vencimiento',  // 映射数据库字段
            'Acciones' => 'Acciones',
        ];
    }
}
