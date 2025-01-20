<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Categoria extends ActiveRecord
{
    /**
     * Nombre de la tabla asociada.
     */
    public static function tableName()
    {
        return 'categorias';
    }

    /**
     * Reglas de validación para los campos del modelo.
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
            [['descripcion'], 'string'],
            [['id_padre'], 'integer'],
            [['id_padre'], 'exist', 'skipOnError' => true, 'targetClass' => self::className(), 'targetAttribute' => ['id_padre' => 'id']],
        ];
    }

    /**
     * Etiquetas para los atributos del modelo.
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
            'id_padre' => 'Categoría Padre',
        ];
    }

    /**
     * Relación con subcategorías (jerarquía).
     *
     * @return ActiveQuery
     */
    public function getSubcategorias()
    {
        return $this->hasMany(self::className(), ['id_padre' => 'id']);
    }

    /**
     * Relación con la categoría padre (jerarquía).
     *
     * @return ActiveQuery
     */
    public function getPadre()
    {
        return $this->hasOne(self::className(), ['id' => 'id_padre']);
    }
}
