<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class IncidenciaSearch extends Incidencia
{
    public function rules()
    {
        return [
            [['id', 'creado_por', 'revisado_por'], 'integer'],
            [['descripcion', 'estado', 'fecha_creacion', 'fecha_revision'], 'safe'],
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

        return $dataProvider;
    }
}
