<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Etiqueta extends ActiveRecord
{
    /**
     * Define el nombre de la tabla asociada.
     */
    public static function tableName()
    {
        return 'etiquetas';
    }

    /**
     * Define las reglas de validación para los campos del modelo.
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'], // El campo 'nombre' es obligatorio
            [['nombre'], 'string', 'max' => 255], // Máximo 255 caracteres para 'nombre'
            [['descripcion'], 'string'], // 'descripcion' es opcional y de tipo texto
        ];
    }

    /**
     * Define las etiquetas para los atributos del modelo.
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
     * Una etiqueta puede eliminarse si no tiene categorías asociadas.
     *
     * @return bool
     */
    public function canBeDeleted()
    {
        return $this->getCategorias()->count() === 0;
    }

    /**
     * Relación con las categorías asociadas a la etiqueta.
     *
     * @return ActiveQuery
     */
    public function getCategorias()
    {
        return $this->hasMany(Categoria::class, ['id' => 'id_categoria'])
                    ->viaTable('categoria_etiqueta', ['id_etiqueta' => 'id']);
    }

    /**
     * Relación con las alertas asociadas a la etiqueta.
     *
     * @return ActiveQuery
     */
    public function getAlertas()
    {
        return $this->hasMany(Alerta::class, ['id' => 'id_alerta'])
                    ->viaTable('alerta_etiqueta', ['id_etiqueta' => 'id']);
    }
}
