<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class IncidenciaSearch extends Incidencia
{
    public $fecha_inicio;
    public $fecha_fin;

    public function rules()
    {
        return [
            [['id', 'creado_por', 'revisado_por'], 'integer'],
            [['descripcion', 'estado', 'fecha_creacion', 'fecha_revision', 'fecha_inicio', 'fecha_fin'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Incidencia::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['id' => $this->id])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['estado' => $this->estado])
            ->andFilterWhere(['creado_por' => $this->creado_por]);

        // Fecha de creación entre fecha_inicio y fecha_fin
        if ($this->fecha_inicio && $this->fecha_fin) {
            $query->andFilterWhere(['between', 'fecha_creacion', $this->fecha_inicio, $this->fecha_fin]);
        }

        // Filtro para no revisadas
        if ($this->estado == 'no revisada') {
            $query->andFilterWhere(['estado' => 'no revisada']);
        }

        return $dataProvider;
    }
}
