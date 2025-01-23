<?php

namespace app\models;

<<<<<<< HEAD
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
=======
use Yii;
use yii\db\ActiveRecord;

class Alerta extends ActiveRecord
{
    public static function tableName()
    {
        return 'alerta';
    }

    public function rules()
    {
        return [
            [['titulo', 'descripcion', 'fecha_inicio', 'duracion_estimada', 'id_lugar', 'estado', 'id_usuario'], 'required'],
            [['fecha_inicio'], 'datetime'],
            [['duracion_estimada'], 'integer'],
            [['titulo'], 'string', 'max' => 255],
            [['descripcion', 'detalles', 'notas', 'url_externa'], 'string'],
            [['id_lugar', 'id_usuario'], 'integer'],
            [['estado'], 'string', 'max' => 50],
        ];
    }

>>>>>>> alba_develop
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Título',
            'descripcion' => 'Descripción',
<<<<<<< HEAD
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
=======
            'fecha_inicio' => 'Fecha de Inicio',
            'duracion_estimada' => 'Duración Estimada',
            'id_lugar' => 'Lugar',
            'detalles' => 'Detalles',
            'notas' => 'Notas',
            'url_externa' => 'URL Externa',
            'estado' => 'Estado',
            'id_usuario' => 'Usuario Creador',
        ];
    }

    public function getLugar()
    {
        return $this->hasOne(Lugar::class, ['id' => 'id_lugar']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'id_usuario']);
    }

    public function getComentarios()
    {
        return $this->hasMany(Comentario::class, ['id_alerta' => 'id']);
    }

    public function getEtiquetas()
    {
        return $this->hasMany(Etiqueta::class, ['id' => 'id_etiqueta'])
            ->viaTable('alerta_etiqueta', ['id_alerta' => 'id']);
    }
}
>>>>>>> alba_develop
