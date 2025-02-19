<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Categoria extends ActiveRecord
{
    /**
     * Nombre de la tabla asociada.
     */
    public static function tableName()
    {
        return 'categorias';
    }

    /**
     * Propiedad para manejar las etiquetas seleccionadas en el formulario.
     */
    public $etiquetasSeleccionadas;

    /**
     * Reglas de validación para los campos del modelo.
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
            [['descripcion'], 'string'],
            [['id_padre'], 'integer'],
            [['id_padre'], 'exist', 'skipOnError' => true, 'targetClass' => self::className(), 'targetAttribute' => ['id_padre' => 'id']],
            [['etiquetasSeleccionadas'], 'safe'], // Permitir que Yii procese las etiquetas seleccionadas
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
            'id_padre' => 'Categoría Padre',
            'etiquetasSeleccionadas' => 'Etiquetas Asociadas',
        ];
    }

    /**
     * Relación con subcategorías (jerarquía).
     *
     * @return ActiveQuery
     */
    public function getSubcategorias()
    {
        return $this->hasMany(self::className(), ['id_padre' => 'id']);
    }

    /**
     * Relación con la categoría padre (jerarquía).
     *
     * @return ActiveQuery
     */
    public function getPadre()
    {
        return $this->hasOne(self::className(), ['id' => 'id_padre']);
    }

    /**
     * Relación con las etiquetas asociadas a la categoría.
     *
     * @return ActiveQuery
     */
    public function getEtiquetas()
    {
        return $this->hasMany(Etiqueta::className(), ['id' => 'id_etiqueta'])
                    ->viaTable('categoria_etiqueta', ['id_categoria' => 'id']);
    }

    /**
     * Después de guardar, actualizar la relación con etiquetas.
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        // Eliminar relaciones anteriores
        \Yii::$app->db->createCommand()
            ->delete('categoria_etiqueta', ['id_categoria' => $this->id])
            ->execute();

        // Insertar nuevas relaciones
        if (!empty($this->etiquetasSeleccionadas)) {
            $rows = [];
            foreach ($this->etiquetasSeleccionadas as $etiquetaId) {
                $rows[] = [$this->id, $etiquetaId];
            }
            \Yii::$app->db->createCommand()
                ->batchInsert('categoria_etiqueta', ['id_categoria', 'id_etiqueta'], $rows)
                ->execute();
        }
    }

    /**
     * Cargar etiquetas asociadas cuando se consulta una categoría.
     */
    public function afterFind()
    {
        parent::afterFind();

        // Cargar etiquetas seleccionadas desde la tabla intermedia
        $this->etiquetasSeleccionadas = \Yii::$app->db->createCommand(
            'SELECT id_etiqueta FROM categoria_etiqueta WHERE id_categoria = :id',
            [':id' => $this->id]
        )->queryColumn();
    }
}
