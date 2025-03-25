<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "imagen".
 *
 * @property int $id ID único de la imagen
 * @property string $nombre Nombre original del archivo
 * @property string $ruta Ruta de almacenamiento de la imagen
 * @property int $usuario_id ID del usuario que subió la imagen
 * @property int $alerta_id ID de la alerta asociada
 * @property int $tam_img Tamaño del archivo en bytes
 * @property string|null $metadatos Información extra de la imagen (opcional)
 * @property string $created_at Fecha y hora de subida
 *
 * @property Alertas $alerta
 * @property Usuario $usuario
 */
class Imagen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'imagen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'usuario_id', 'alerta_id', 'tam_img'], 'required'],
            [['usuario_id', 'alerta_id', 'tam_img'], 'integer'],
            [['metadatos'], 'string'],
            [['created_at'], 'safe'],
            [['nombre'], 'string', 'max' => 255],
            [['alerta_id'], 'exist', 'skipOnError' => true, 'targetClass' => Alertas::class, 'targetAttribute' => ['alerta_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::class, 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'usuario_id' => 'Usuario ID',
            'alerta_id' => 'Alerta ID',
            'tam_img' => 'Tamaño',
            'metadatos' => 'Metadatos',
            'created_at' => 'Fecha de Creación',
        ];
    }

    /**
     * Gets query for [[Alerta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlerta()
    {
        return $this->hasOne(Alerta::class, ['id' => 'alerta_id']);
    }

    /**
     * Gets query for [[Usuario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_id']);
    }
}
