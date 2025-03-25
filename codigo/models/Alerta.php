<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Esta es la clase modelo para la tabla "alertas".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $fecha_creacion
 * @property string|null $fecha_expiracion
 * @property string|null $completado_en
 * @property int|null $id_categoria
 * @property int|null $id_ubicacion
 * @property int|null $id_imagen
 * @property string $estado
 * @property int|null $usuario_id
 * @property int|null $id_etiqueta
 *
 * @property AlertaEtiqueta[] $alertaEtiquetas
 * @property Comentario[] $comentarios
 * @property Etiqueta[] $etiquetas
 * @property Incidencia[] $incidencias
 * @property Categoria $categoria
 * @property Usuario $usuario
 * @property Ubicacion $ubicacion
 * @property Imagen $imagen
 */
class Alerta extends ActiveRecord
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
            [['titulo', 'descripcion', 'estado'], 'required'],
            [['descripcion', 'detalles', 'notas', 'url_externa'], 'string'],
            [['fecha_creacion', 'fecha_expiracion', 'completado_en'], 'safe'],
            [['id_categoria', 'id_ubicacion', 'id_imagen', 'usuario_id', 'id_etiqueta'], 'integer'],
            [['titulo'], 'string', 'max' => 255],
            [['estado'], 'string', 'max' => 50],
            [['id_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['id_categoria' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuario_id' => 'id']],
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
            'titulo' => 'Título',
            'descripcion' => 'Descripción',
            'fecha_creacion' => 'Fecha de Creación',
            'fecha_expiracion' => 'Fecha de Expiración',
            'completado_en' => 'Completado en',
            'id_categoria' => 'Categoría',
            'id_ubicacion' => 'Ubicación',
            'detalles' => 'Detalles',
            'notas' => 'Notas',
            'url_externa' => 'URL Externa',
            'estado' => 'Estado',
            'usuario_id' => 'Usuario',
            'id_imagen' => 'Imagen',
            'id_etiqueta' => 'Etiqueta',
        ];
    }

    /**
     * Relación con el modelo Categoría.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'id_categoria']);
    }

    /**
     * Relación con el modelo Ubicación.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUbicacion()
    {
        return $this->hasOne(Ubicacion::class, ['id' => 'id_ubicacion']);
    }

    /**
     * Relación con el modelo Lugar.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLugar()
    {
        return $this->hasOne(Lugar::class, ['id' => 'id_lugar']);
    }

    /**
     * Relación con el modelo Usuario.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'id_usuario']);
    }

    /**
     * Relación con el modelo Imagen.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getImagen()
    {
        return $this->hasOne(Imagen::class, ['id' => 'id_imagen']);
    }

    /**
     * Relación con el modelo Incidencia.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIncidencias()
    {
        return $this->hasMany(Incidencia::class, ['id_alerta' => 'id']);
    }

    /**
     * Relación con el modelo Comentario.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentario::class, ['id_alerta' => 'id']);
    }

    /**
     * Relación con el modelo Etiqueta a través de AlertaEtiqueta.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEtiquetas()
    {
        return $this->hasMany(Etiqueta::class, ['id' => 'id_etiqueta'])->viaTable('alerta_etiqueta', ['id_alerta' => 'id']);
    }

    /**
     * Relación con el modelo AlertaEtiqueta.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlertaEtiquetas()
    {
        return $this->hasMany(AlertaEtiqueta::class, ['id_alerta' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return AlertaQuery la consulta activa usada por esta clase AR.
     */
    public static function find()
    {
        return new AlertaQuery(get_called_class());
    }

    /**
     * Lista las alertas de un usuario.
     *
     * @param int $usuarioId
     * @return Alerta[]
     */
    public static function listarPorUsuario($usuarioId)
    {
        return self::find()->where(['id_usuario' => $usuarioId])->all();
    }

    /**
     * Crea una nueva alerta.
     *
     * @param array $data
     * @return bool
     */
    public function crearAlerta($data)
    {
        $this->load($data, '');
        return $this->save();
    }

    /**
     * Edita una alerta existente.
     *
     * @param array $data
     * @return bool
     */
    public function editarAlerta($data)
    {
        $this->load($data, '');
        return $this->save();
    }

    /**
     * Elimina una alerta.
     *
     * @return bool
     */
    public function eliminarAlerta()
    {
        return $this->delete();
    }
}
