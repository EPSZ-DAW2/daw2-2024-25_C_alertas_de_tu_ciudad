<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Comentario extends ActiveRecord
{
<<<<<<< HEAD
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
=======
    public static function tableName()
    {
        return 'comentario';
    }

    public function rules()
    {
        return [
            [['texto', 'id_alerta', 'id_usuario'], 'required'],
            [['texto'], 'string'],
            [['id_alerta', 'id_usuario', 'estado_cierre', 'num_denuncias'], 'integer'],
            [['bloqueado'], 'boolean'],
        ];
    }

>>>>>>> alba_develop
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
<<<<<<< HEAD
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
=======
            'texto' => 'Texto',
            'id_alerta' => 'ID Alerta',
            'id_usuario' => 'ID Usuario',
            'estado_cierre' => 'Estado de Cierre',
            'num_denuncias' => 'Número de Denuncias',
            'bloqueado' => 'Bloqueado',
        ];
    }

    public function getAlerta()
    {
        return $this->hasOne(Alerta::class, ['id' => 'id_alerta']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'id_usuario']);
    }
}
>>>>>>> alba_develop
