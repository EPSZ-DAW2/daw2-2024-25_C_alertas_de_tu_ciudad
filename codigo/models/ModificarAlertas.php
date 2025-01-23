<?php

namespace app\models;

use yii\db\ActiveRecord;

class ModificarAlertas extends ActiveRecord
{
    /**
     * 定义关联的数据库表
     */
    public static function tableName()
    {
        return 'alertas'; // 数据库中的表名
    }

    /**
     * 定义验证规则
     */
    public function rules()
    {
        return [
            [['titulo', 'descripcion', 'fecha_expiracion'], 'required'], // 必填字段
            [['titulo'], 'string', 'max' => 255], // 标题最大长度
            [['descripcion'], 'string'], // 描述是字符串
            [['fecha_expiracion'], 'datetime', 'format' => 'php:Y-m-d\TH:i'], // 过期时间必须是有效的日期时间格式
        ];
    }

    /**
     * 加载已有数据（可选，不一定需要）
     * @param Alertas $alerta
     */
    public function loadData($alerta)
    {
        $this->id = $alerta->id;
        $this->titulo = $alerta->titulo;
        $this->descripcion = $alerta->descripcion;
        $this->fecha_expiracion = $alerta->fecha_expiracion;
    }

    /**
     * 保存修改的数据到数据库
     */
    public function saveAlert()
    {
        $alerta = self::findOne($this->id); // 根据ID查找记录
        if ($alerta) {
            $alerta->titulo = $this->titulo;
            $alerta->descripcion = $this->descripcion;
            $alerta->fecha_expiracion = $this->fecha_expiracion;
            return $alerta->save(); // 保存到数据库
        }
        return false; // 未找到记录，保存失败
    }
}
