<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Alerta extends ActiveRecord
{
    /**
     * Nombre de la tabla asociada.
     */
    public static function tableName()
    {
        return 'alertas';
    }

    /**
     * Reglas de validación para los campos del modelo.
     */
    public function rules()
    {
        return [
            [['titulo', 'descripcion'], 'required'],
            [['descripcion'], 'string'],
            [['id_etiqueta'], 'integer'],
            [['titulo'], 'string', 'max' => 255],
            [['id_etiqueta'], 'exist', 'skipOnError' => true, 'targetClass' => Etiqueta::className(), 'targetAttribute' => ['id_etiqueta' => 'id']],
        ];
    }

    /**
     * Etiquetas para los atributos del modelo.
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título',
            'descripcion' => 'Descripción',
            'id_etiqueta' => 'Etiqueta Relacionada',
        ];
    }

    /**
     * Relación con la tabla de etiquetas.
     *
     * @return ActiveQuery
     */
    public function getEtiqueta()
    {
        return $this->hasOne(Etiqueta::className(), ['id' => 'id_etiqueta']);
    }
}
