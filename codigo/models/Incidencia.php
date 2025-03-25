<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Incidencia extends ActiveRecord
{
    /**
     * Nombre de la tabla asociada.
     */
    public static function tableName()
    {
        return 'incidencias';
    }

    /**
     * Reglas de validación para los campos del modelo.
     */
    public function rules()
    {
        return [
            [['texto', 'id_usuario'], 'required'],
            [['texto', 'descripcion', 'respuesta'], 'string'],
            [['id_usuario', 'id_alerta', 'id_comentario', 'creado_por', 'revisado_por'], 'integer'],
            [['fecha_lectura', 'fecha_creacion', 'fecha_revision'], 'safe'],
            [['estado'], 'in', 'range' => ['nueva', 'revisada', 'no revisada']],
        ];
    }

    /**
     * Etiquetas para los atributos del modelo.
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'texto' => 'Texto',
            'descripcion' => 'Descripción',
            'estado' => 'Estado',
            'id_usuario' => 'ID Usuario',
            'id_alerta' => 'ID Alerta',
            'id_comentario' => 'ID Comentario',
            'fecha_lectura' => 'Fecha de Lectura',
            'creado_por' => 'Creado Por',
            'fecha_creacion' => 'Fecha de Creación',
            'fecha_revision' => 'Fecha de Revisión',
            'revisado_por' => 'Revisado Por',
            'respuesta' => 'Respuesta',
        ];
    }

    /**
     * Relación con la tabla `usuario`.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'id_usuario']);
    }

    /**
     * Relación con la tabla `alerta`.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlerta()
    {
        return $this->hasOne(Alerta::class, ['id' => 'id_alerta']);
    }

    /**
     * Relación con la tabla `comentario`.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentario()
    {
        return $this->hasOne(Comentario::class, ['id' => 'id_comentario']);
    }

    /**
     * Relación con el usuario creador.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCreador()
    {
        return $this->hasOne(Usuario::class, ['id' => 'creado_por']);
    }

    /**
     * Relación con el usuario revisor.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRevisor()
    {
        return $this->hasOne(Usuario::class, ['id' => 'revisado_por']);
    }
}
