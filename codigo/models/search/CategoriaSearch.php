<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Categoria;

class CategoriaSearch extends Categoria
{
    /**
     * Define reglas de validación para la búsqueda.
     */
    public function rules()
    {
        return [
            [['id', 'id_padre'], 'integer'],
            [['nombre', 'descripcion'], 'safe'],
        ];
    }

    /**
     * Configuración de escenarios.
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Configuración del proveedor de datos.
     */
    public function search($params)
    {
        $query = Categoria::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'id_padre' => $this->id_padre,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
              ->andFilterWhere(['like', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
