<?php

namespace app\models;

use Yii;
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
            [['titulo', 'descripcion', 'fecha_inicio', 'duracion_estimada', 'id_lugar', 'estado', 'id_usuario'], 'required'],
            [['descripcion', 'detalles', 'notas', 'url_externa'], 'string'],
            [['fecha_inicio'], 'datetime'],
            [['duracion_estimada', 'id_lugar', 'id_usuario'], 'integer'],
            [['titulo'], 'string', 'max' => 255],
            [['estado'], 'string', 'max' => 50],
            [['id_etiqueta'], 'exist', 'skipOnError' => true, 'targetClass' => Etiqueta::class, 'targetAttribute' => ['id_etiqueta' => 'id']],
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
            'fecha_inicio' => 'Fecha de Inicio',
            'duracion_estimada' => 'Duración Estimada',
            'id_lugar' => 'Lugar',
            'detalles' => 'Detalles',
            'notas' => 'Notas',
            'url_externa' => 'URL Externa',
            'estado' => 'Estado',
            'id_usuario' => 'Usuario Creador',
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
        return $this->hasOne(Etiqueta::class, ['id' => 'id_etiqueta']);
    }

    /**
     * Relación con la tabla de lugares.
     *
     * @return ActiveQuery
     */
    public function getLugar()
    {
        return $this->hasOne(Lugar::class, ['id' => 'id_lugar']);
    }

    /**
     * Relación con la tabla de usuarios.
     *
     * @return ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'id_usuario']);
    }

    /**
     * Relación con los comentarios asociados.
     *
     * @return ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentario::class, ['id_alerta' => 'id']);
    }

    /**
     * Relación con las etiquetas asociadas.
     *
     * @return ActiveQuery
     */
    public function getEtiquetas()
    {
        return $this->hasMany(Etiqueta::class, ['id' => 'id'])
            ->viaTable('alerta_etiqueta', ['id_alerta' => 'id']);
    }
}
