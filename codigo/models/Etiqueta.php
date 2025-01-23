<?php

namespace app\models;

<<<<<<< HEAD
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;

class Etiqueta extends ActiveRecord
{
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
=======
use Yii;
use yii\db\ActiveRecord;

class Etiqueta extends ActiveRecord
{
    public static function tableName()
    {
        return 'etiqueta';
    }

>>>>>>> alba_develop
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
<<<<<<< HEAD
            [['descripcion'], 'string'],
        ];
    }

    /**
     * Etiquetas para los atributos del modelo.
     */
=======
        ];
    }

>>>>>>> alba_develop
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
<<<<<<< HEAD
            'descripcion' => 'Descripción',
        ];
    }

    /**
     * Verifica si la etiqueta puede ser eliminada.
     */
    public function canBeDeleted()
    {
        return $this->getCategorias()->count() === 0;
    }

    /**
     * Relación con las categorías asociadas a la etiqueta.
     *
     * @return ActiveQuery
     */
    public function getCategorias()
    {
        return $this->hasMany(Categoria::className(), ['id' => 'id_categoria'])
                    ->viaTable('categoria_etiqueta', ['id_etiqueta' => 'id']);
    }
}
=======
        ];
    }

    public function getAlertas()
    {
        return $this->hasMany(Alerta::class, ['id' => 'id_alerta'])
            ->viaTable('alerta_etiqueta', ['id_etiqueta' => 'id']);
    }
}
>>>>>>> alba_develop
