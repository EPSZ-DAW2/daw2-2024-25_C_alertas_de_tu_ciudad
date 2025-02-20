<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "alerta".
 *
 * @property int $id
 * @property string $titulo
 * @property string $descripcion
 * @property string $fecha_inicio
 * @property int|null $duracion_estimada (en minutos)
 * @property int|null $id_lugar
 * @property float|null $latitud
 * @property float|null $longitud
 * @property string|null $detalles
 * @property string|null $notas
 * @property string|null $url_externa
 * @property string $estado
 * @property int|null $id_usuario
 * @property int|null $id_categoria
 *
 * @property Categoria $categoria
 * @property Lugar $lugar
 * @property Usuario $usuario
 * @property AlertaEtiqueta[] $alertaEtiquetas
 * @property Comentario[] $comentarios
 * @property Etiqueta[] $etiquetas
 * @property Incidencia[] $incidencias
 * @property ImagenAlerta[] $imagenes
 * @property Denuncia[] $denuncias
 */
class Alerta extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alerta';
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
            [['duracion_estimada', 'id_lugar', 'id_usuario', 'id_categoria'], 'integer'],
            [['latitud', 'longitud'], 'number'],
            [['titulo'], 'string', 'max' => 255],
            [['estado'], 'string', 'max' => 50],
            [['estado'], 'in', 'range' => ['activa', 'cerrada', 'pendiente']],
            [['id_lugar'], 'exist', 'skipOnError' => true, 'targetClass' => Lugar::class, 'targetAttribute' => ['id_lugar' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['id_usuario' => 'id']],
            [['id_categoria'], 'exist', 'skipOnError' => true, 'targetClass' => Categoria::class, 'targetAttribute' => ['id_categoria' => 'id']],
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
            'fecha_inicio' => 'Fecha de Inicio',
            'duracion_estimada' => 'Duración Estimada (minutos)',
            'id_lugar' => 'Ubicación',
            'latitud' => 'Latitud',
            'longitud' => 'Longitud',
            'detalles' => 'Detalles',
            'notas' => 'Notas',
            'url_externa' => 'URL Externa',
            'estado' => 'Estado',
            'id_usuario' => 'Usuario Publicador',
            'id_categoria' => 'Categoría',
        ];
    }

    /**
     * Relación con Categoría.
     */
    public function getCategoria()
    {
        return $this->hasOne(Categoria::class, ['id' => 'id_categoria']);
    }

    /**
     * Relación con Lugar (ubicación de la alerta).
     */
    public function getLugar()
    {
        return $this->hasOne(Lugar::class, ['id' => 'id_lugar']);
    }

    /**
     * Relación con Usuario que publicó la alerta.
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'id_usuario']);
    }

    /**
     * Relación con etiquetas asociadas a la alerta.
     */
    public function getEtiquetas()
    {
        return $this->hasMany(Etiqueta::class, ['id' => 'id_etiqueta'])->viaTable('alerta_etiqueta', ['id_alerta' => 'id']);
    }

    /**
     * Relación con comentarios de la alerta.
     */
    public function getComentarios()
    {
        return $this->hasMany(Comentario::class, ['id_alerta' => 'id']);
    }

    /**
     * Obtiene los comentarios raíz (hilos principales).
     */
    public function getComentariosRaiz()
    {
        return $this->hasMany(Comentario::class, ['id_alerta' => 'id'])
                    ->andWhere(['id_comentario_padre' => null]);
    }

    /**
     * Relación con imágenes asociadas a la alerta.
     */
    public function getImagenes()
    {
        return $this->hasMany(ImagenAlerta::class, ['id_alerta' => 'id']);
    }

    /**
     * Relación con denuncias de la alerta.
     */
    public function getDenuncias()
    {
        return $this->hasMany(Denuncia::class, ['id_alerta' => 'id']);
    }

    /**
     * Relación con incidencias (problemas reportados sobre la alerta).
     */
    public function getIncidencias()
    {
        return $this->hasMany(Incidencia::class, ['id_alerta' => 'id']);
    }

    /**
     * Calcula la fecha de finalización automáticamente.
     */
    public function getFechaFin()
    {
        if ($this->duracion_estimada) {
            return date('Y-m-d H:i:s', strtotime($this->fecha_inicio . ' +' . $this->duracion_estimada . ' minutes'));
        }
        return null;
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
