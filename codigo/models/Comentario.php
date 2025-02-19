<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Comentario extends ActiveRecord
{
    /**
     * Define el nombre de la tabla asociada.
     */
    public static function tableName()
    {
        return 'comentarios';
    }

    /**
     * Define las reglas de validación.
     */
    public function rules()
    {
        return [
            [['texto', 'id_alerta', 'id_usuario'], 'required'],
            [['texto'], 'string'],
            [['id_alerta', 'id_usuario', 'estado_cierre', 'num_denuncias'], 'integer'],
            [['bloqueado'], 'boolean'],
            [['creado_en', 'actualizado_en'], 'safe'], // Fechas aceptadas como valores válidos
        ];
    }

    /**
     * Define las etiquetas para los atributos.
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'texto' => 'Texto del Comentario',
            'id_alerta' => 'ID de la Alerta',
            'id_usuario' => 'ID del Usuario',
            'estado_cierre' => 'Estado de Cierre',
            'num_denuncias' => 'Número de Denuncias',
            'bloqueado' => 'Bloqueado',
            'creado_en' => 'Fecha de Creación',
            'actualizado_en' => 'Última Actualización',
        ];
    }

    /**
     * Relación con la tabla `alerta`.
     *
     * @return ActiveQuery
     */
    public function getAlerta()
    {
        return $this->hasOne(Alerta::class, ['id' => 'id_alerta']);
    }

    /**
     * Relación con la tabla `usuario`.
     *
     * @return ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'id_usuario']);
    }
}
