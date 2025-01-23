<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Etiqueta extends ActiveRecord
{
    /**
     * Nombre de la tabla asociada.
     */
    public static function tableName()
    {
        return 'etiquetas';
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
        ];
    }

    /**
     * Verifica si la etiqueta puede ser eliminada.
     */
    public function canBeDeleted()
    {
        return $this->getCategorias()->count() === 0 && $this->getAlertas()->count() === 0;
    }

    /**
     * Relación con la tabla de categorías.
     *
     * @return ActiveQuery
     */
    public function getCategorias()
    {
        return $this->hasMany(Categoria::className(), ['id_etiqueta' => 'id']);
    }

    /**
     * Relación con la tabla de alertas.
     *
     * @return ActiveQuery
     */
    public function getAlertas()
    {
        return $this->hasMany(Alerta::className(), ['id_etiqueta' => 'id']);
    }
}
