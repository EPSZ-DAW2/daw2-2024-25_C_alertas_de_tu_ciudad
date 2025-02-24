<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alerta".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $fecha_inicio
 * @property int|null $duracion_estimada
 * @property int|null $id_lugar
 * @property string|null $detalles
 * @property string|null $notas
 * @property string|null $url_externa
 * @property string $estado
 * @property int|null $id_usuario
 *
 * @property AlertaEtiqueta[] $alertaEtiquetas
 * @property Comentario[] $comentarios
 * @property Etiqueta[] $etiquetas
 * @property Incidencia[] $incidencias
 * @property Lugar $lugar
 * @property Usuario $usuario
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
            [['duracion_estimada', 'id_lugar', 'id_usuario'], 'integer'],
            [['titulo'], 'string', 'max' => 255],
            [['estado'], 'string', 'max' => 50],
            [['id_lugar'], 'exist', 'skipOnError' => true, 'targetClass' => Lugar::class, 'targetAttribute' => ['id_lugar' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['id_usuario' => 'id']],
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
            'detalles' => 'Detalles',
            'notas' => 'Notas',
            'url_externa' => 'Url Externa',
            'estado' => 'Estado',
            'id_usuario' => 'Id Usuario',
        ];
    }

    /**
     * Gets query for [[AlertaEtiquetas]].
     *
     * @return \yii\db\ActiveQuery|AlertaEtiquetaQuery
     */
    public function getAlertaEtiquetas()
    {
        return $this->hasMany(AlertaEtiqueta::class, ['id_alerta' => 'id']);
    }

    /**
     * Gets query for [[Comentarios]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentario::class, ['id_alerta' => 'id']);
    }

    /**
     * Gets query for [[Etiquetas]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getEtiquetas()
    {
        return $this->hasMany(Etiqueta::class, ['id' => 'id_etiqueta'])->viaTable('alerta_etiqueta', ['id_alerta' => 'id']);
    }

    /**
     * Gets query for [[Incidencias]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getIncidencias()
    {
        return $this->hasMany(Incidencia::class, ['id_alerta' => 'id']);
    }

    /**
     * Gets query for [[Lugar]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getLugar()
    {
        return $this->hasOne(Lugar::class, ['id' => 'id_lugar']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'id_usuario']);
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
