<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alertas".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $fecha_inicio
 * @property int|null $duracion_estimada
 * @property int|null $id_lugar
 * @property int|null $id_ubicacion
 * @property string|null $detalles
 * @property string|null $notas
 * @property string|null $url_externa
 * @property string $estado
 * @property int|null $id_usuario
 * @property int|null $id_imagen
 *
 * @property AlertaEtiqueta[] $alertaEtiquetas
 * @property Comentario[] $comentarios
 * @property Etiqueta[] $etiquetas
 * @property Incidencia[] $incidencias
 * @property Lugar $lugar
 * @property Usuario $usuario
 * @property Ubicacion $ubicacion
 * @property Imagen $imagen
 */
class Alerta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alertas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'descripcion', 'fecha_inicio', 'estado'], 'required'],
            [['descripcion', 'detalles', 'notas', 'url_externa'], 'string'],
            [['fecha_inicio'], 'safe'],
            [['duracion_estimada', 'id_lugar', 'id_usuario', 'id_ubicacion', 'id_imagen'], 'integer'],
            [['titulo'], 'string', 'max' => 255],
            [['estado'], 'string', 'max' => 50],
            [['id_lugar'], 'exist', 'skipOnError' => true, 'targetClass' => Lugar::class, 'targetAttribute' => ['id_lugar' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['id_usuario' => 'id']],
            [['id_ubicacion'], 'exist', 'skipOnError' => true, 'targetClass' => Ubicacion::class, 'targetAttribute' => ['id_ubicacion' => 'id']],
            [['id_imagen'], 'exist', 'skipOnError' => true, 'targetClass' => Imagen::class, 'targetAttribute' => ['id_imagen' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'titulo' => 'Titulo',
            'descripcion' => 'Descripcion',
            'fecha_inicio' => 'Fecha Inicio',
            'duracion_estimada' => 'Duracion Estimada',
            'id_lugar' => 'Id Lugar',
            'id_ubicacion' => 'Id Ubicacion',
            'detalles' => 'Detalles',
            'notas' => 'Notas',
            'url_externa' => 'Url Externa',
            'estado' => 'Estado',
            'id_usuario' => 'Id Usuario',
            'id_imagen' => 'Id Imagen',
        ];
    }

    /**
     * Gets query for [[Ubicacion]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUbicacion()
    {
        return $this->hasOne(Ubicacion::class, ['id' => 'id_ubicacion']);
    }

    public function getLugar()
    {
        return $this->hasOne(Lugar::class, ['id' => 'id_lugar']);
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'id_usuario']);
    }

    public function getImagen()
    {
        return $this->hasOne(Imagen::class, ['id' => 'id_imagen']);
    }

    public function getIncidencias()
    {
        return $this->hasMany(Incidencia::class, ['id_alerta' => 'id']);
    }

    public function getComentarios()
    {
        return $this->hasMany(Comentario::class, ['id_alerta' => 'id']);
    }

    public function getEtiquetas()
    {
        return $this->hasMany(Etiqueta::class, ['id' => 'id_etiqueta'])->viaTable('alerta_etiqueta', ['id_alerta' => 'id']);
    }

    public function getAlertaEtiquetas()
    {
        return $this->hasMany(AlertaEtiqueta::class, ['id_alerta' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AlertaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AlertaQuery(get_called_class());
    }
}
