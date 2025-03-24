<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

class Etiqueta extends ActiveRecord
{
    /**
     * Propiedad para manejar las categorías seleccionadas.
     */
    public $categoriasSeleccionadas;

    /**
     * Propiedad para manejar las alertas seleccionadas.
     */
    public $alertasSeleccionadas;

    /**
     * Nombre de la tabla asociada.
     */
    public static function tableName()
    {
        return 'etiquetas';
    }

    /**
     * Reglas de validación para los campos del modelo.
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
            [['descripcion'], 'string'],
            [['categoriasSeleccionadas'], 'safe'],
            [['alertasSeleccionadas'], 'safe'],
        ];
    }

    /**
     * Etiquetas para los atributos del modelo.
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripción',
            'categoriasSeleccionadas' => 'Categorías',
            'alertasSeleccionadas' => 'Alertas Asociadas',
        ];
    }

    /**
     * Relación para obtener las alertas asociadas a la etiqueta a través de la tabla intermedia.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlertas()
    {
        return $this->hasMany(\app\models\Alerta::className(), ['id_categoria' => 'id_categoria'])
                    ->viaTable('categoria_etiqueta', ['id_etiqueta' => 'id']);
    }

    /**
     * Relación para obtener las alertas asociadas a esta etiqueta directamente,
     * usando el campo 'id_etiqueta' de la tabla 'alertas'.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlertasDirect()
    {
        return $this->hasMany(\app\models\Alerta::className(), ['id_etiqueta' => 'id']);
    }

    /**
     * Relación con la tabla de categorías.
     *
     * @return ActiveQuery
     */
    public function getCategorias()
    {
        return $this->hasMany(Categoria::className(), ['id' => 'id_categoria'])
                    ->viaTable('categoria_etiqueta', ['id_etiqueta' => 'id']);
    }

    /**
     * Verifica si la etiqueta puede ser eliminada.
     */
    public function canBeDeleted()
    {
        return $this->getCategorias()->count() === 0 && $this->getAlertasDirect()->count() === 0;
    }

    /**
     * Cargar categorías seleccionadas al obtener el modelo.
     */
    public function afterFind()
    {
        parent::afterFind();
        $this->categoriasSeleccionadas = ArrayHelper::getColumn($this->getCategorias()->asArray()->all(), 'id');
    }

    /**
     * Guardar las relaciones con categorías y alertas después de guardar la etiqueta.
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Procesar relaciones de categorías:
        \Yii::$app->db->createCommand()
            ->delete('categoria_etiqueta', ['id_etiqueta' => $this->id])
            ->execute();

        if (!empty($this->categoriasSeleccionadas)) {
            foreach ($this->categoriasSeleccionadas as $idCategoria) {
                \Yii::$app->db->createCommand()
                    ->insert('categoria_etiqueta', [
                        'id_etiqueta' => $this->id,
                        'id_categoria' => $idCategoria,
                    ])->execute();
            }
        }

        // Procesar relaciones de alertas:
        if (empty($this->alertasSeleccionadas)) {
            // Si no se seleccionaron alertas, quitar la asociación de todas las alertas que actualmente tienen este id_etiqueta.
            \Yii::$app->db->createCommand()
                ->update('alertas', ['id_etiqueta' => null], ['id_etiqueta' => $this->id])
                ->execute();
        } else {
            // Primero, desasociar alertas que ya no estén seleccionadas.
            \Yii::$app->db->createCommand()
                ->update('alertas', ['id_etiqueta' => null], ['and', ['id_etiqueta' => $this->id], ['not in', 'id', $this->alertasSeleccionadas]])
                ->execute();
            // Luego, asociar alertas seleccionadas.
            \Yii::$app->db->createCommand()
                ->update('alertas', ['id_etiqueta' => $this->id], ['in', 'id', $this->alertasSeleccionadas])
                ->execute();
        }
    }
}