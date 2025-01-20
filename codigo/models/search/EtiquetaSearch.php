<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Etiqueta;

class EtiquetaSearch extends Etiqueta
{
    /**
     * Reglas de validación para el modelo de búsqueda.
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nombre', 'descripcion', 'creado_en', 'actualizado_en'], 'safe'],
        ];
    }

    /**
     * Escenario de búsqueda.
     */
    public function scenarios()
    {
        // Ignorar los escenarios de la clase base.
        return Model::scenarios();
    }

    /**
     * Crea un proveedor de datos con la consulta aplicada.
     */
    public function search($params)
    {
        $query = Etiqueta::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // Si la validación falla, no devolver ningún resultado.
            $query->where('0=1');
            return $dataProvider;
        }

        // Filtrar los datos según los parámetros proporcionados.
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['like', 'nombre', $this->nombre])
              ->andFilterWhere(['like', 'descripcion', $this->descripcion])
              ->andFilterWhere(['>=', 'creado_en', $this->creado_en])
              ->andFilterWhere(['<=', 'actualizado_en', $this->actualizado_en]);

        return $dataProvider;
    }
}
