<?php
namespace app\models;

use yii\db\ActiveRecord;

class Notificacion extends ActiveRecord
{
    public static function tableName()
    {
        return 'notificacion';  // 表名
    }

    public function rules()
    {
        return [
            [['usuario_id', 'mensaje'], 'required'],
            ['mensaje', 'string'],
            ['fecha', 'safe'],
            ['Acciones', 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'mensaje' => 'Mensaje de Notificación',
            'fecha' => 'Fecha de Notificación',
            'Acciones' => 'Acciones',
        ];
    }
}
