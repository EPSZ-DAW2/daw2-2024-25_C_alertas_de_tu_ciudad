<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Alerta extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%alerta}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['titulo', 'descripcion', 'usuario_id'], 'required'],
            [['descripcion'], 'string'],
            [['usuario_id'], 'integer'],
            [['titulo'], 'string', 'max' => 255],
        ];
    }

    /**
     * Relación con el modelo Usuario
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::class, ['id' => 'usuario_id']);
    }

    /**
     * Listar alertas de un usuario
     * @param int $usuarioId
     * @return Alerta[]
     */
    public static function listarPorUsuario($usuarioId)
    {
        return self::find()->where(['usuario_id' => $usuarioId])->all();
    }

    /**
     * Crear una nueva alerta
     * @param array $data
     * @return bool
     */
    public function crearAlerta($data)
    {
        $this->load($data, '');
        return $this->save();
    }

    /**
     * Editar una alerta existente
     * @param array $data
     * @return bool
     */
    public function editarAlerta($data)
    {
        $this->load($data, '');
        return $this->save();
    }

    /**
     * Eliminar una alerta
     * @return bool
     */
    public function eliminarAlerta()
    {
        return $this->delete();
    }
}
