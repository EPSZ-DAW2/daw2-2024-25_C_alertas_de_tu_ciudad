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
        ];
    }

    /**
     * Relación con la tabla de categorías.
     *
     * @return ActiveQuery
     */
    public function getCategorias()
    {
        return $this->hasMany(Categoria::class, ['id' => 'id_categoria'])
                    ->viaTable('categoria_etiqueta', ['id_etiqueta' => 'id']);
    }

    /**
     * Relación con la tabla de alertas.
     *
     * @return ActiveQuery
     */
    public function getAlertas()
    {
        return $this->hasMany(Alerta::class, ['id' => 'id_etiqueta']);
    }

    /**
     * Verifica si la etiqueta puede ser eliminada.
     */
    public function canBeDeleted()
    {
        return $this->getCategorias()->count() === 0 && $this->getAlertas()->count() === 0;
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
     * Guardar las relaciones con categorías después de guardar la etiqueta.
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Eliminar relaciones existentes
        \Yii::$app->db->createCommand()
            ->delete('categoria_etiqueta', ['id_etiqueta' => $this->id])
            ->execute();

        // Insertar nuevas relaciones
        if (!empty($this->categoriasSeleccionadas)) {
            foreach ($this->categoriasSeleccionadas as $idCategoria) {
                \Yii::$app->db->createCommand()
                    ->insert('categoria_etiqueta', [
                        'id_etiqueta' => $this->id,
                        'id_categoria' => $idCategoria,
                    ])->execute();
            }
        }
    }
}
