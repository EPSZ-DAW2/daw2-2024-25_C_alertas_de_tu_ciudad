<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Alerta extends ActiveRecord
{
    const ESTADO_ACTIVA = 1;
    const ESTADO_FINALIZADA = 2;
    const ESTADO_DESACTIVADA = 3;

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
            [['id_etiqueta', 'estado'], 'integer'],
            [['ultima_modificacion'], 'safe'],
            [['titulo'], 'string', 'max' => 255],
            [['id_etiqueta'], 'exist', 'skipOnError' => true, 'targetClass' => Etiqueta::className(), 'targetAttribute' => ['id_etiqueta' => 'id']],
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
            'id_etiqueta' => 'Etiqueta Relacionada',
            'estado' => 'Estado',
            'ultima_modificacion' => 'Última Modificación',
            'comentarios_visibles' => 'Hilo de Comentarios Visible',
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

    /**
     * Verifica si la alerta puede ser eliminada.
     *
     * @return bool
     */
    public function puedeEliminar()
    {
        // Reemplaza con la lógica para verificar vínculos relacionados.
        return true;
    }

    /**
     * Marca la alerta como finalizada.
     *
     * @return bool
     */
    public function finalizar()
    {
        $this->estado = self::ESTADO_FINALIZADA;
        return $this->save();
    }

    /**
     * Marca la alerta como desactivada.
     *
     * @return bool
     */
    public function desactivar()
    {
        $this->estado = self::ESTADO_DESACTIVADA;
        return $this->save();
    }

    /**
     * Verifica si la alerta ha caducado por tiempo.
     *
     * @param int $dias Tiempo en días.
     * @return bool
     */
    public function haCaducado($dias)
    {
        $ultimaModificacion = strtotime($this->ultima_modificacion);
        $limite = strtotime("-{$dias} days");
        return $ultimaModificacion < $limite;
    }

    /**
     * Bloquea el hilo de comentarios.
     *
     * @return bool
     */
    public function bloquearComentarios()
    {
        $this->comentarios_visibles = false;
        return $this->save();
    }

    /**
     * Desbloquea el hilo de comentarios.
     *
     * @return bool
     */
    public function desbloquearComentarios()
    {
        $this->comentarios_visibles = true;
        return $this->save();
    }
}