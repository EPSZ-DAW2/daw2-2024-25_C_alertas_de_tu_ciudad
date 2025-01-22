<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Comentario extends ActiveRecord
{
    /**
     * Define el nombre de la tabla asociada
     */
    public static function tableName()
    {
        return 'comentarios';
    }

    /**
     * Define las reglas de validación
     */
    public function rules()
    {
        return [
            [['contenido'], 'required'], // El campo contenido es obligatorio
            [['contenido'], 'string'],
            [['numero_denuncias', 'es_denunciado', 'es_visible', 'es_cerrado'], 'integer'],
            [['creado_en', 'actualizado_en'], 'safe'],
        ];
    }

    /**
     * Etiquetas para los atributos (usados en formularios)
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'contenido' => 'Contenido del Comentario',
            'numero_denuncias' => 'Número de Denuncias',
            'es_denunciado' => 'Denunciado',
            'es_visible' => 'Visible',
            'es_cerrado' => 'Cerrado',
            'creado_en' => 'Fecha de Creación',
            'actualizado_en' => 'Última Actualización',
        ];
    }
}
