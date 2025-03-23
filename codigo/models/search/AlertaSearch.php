<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Alerta;

class AlertaSearch extends Alerta
{
    public function rules()
    {
        return [
            [['id', 'duracion_estimada', 'id_lugar', 'id_usuario', 'id_ubicacion', 'id_imagen'], 'integer'],
            [['titulo', 'descripcion', 'fecha_inicio', 'estado'], 'safe'],
            [['id_categoria'], 'integer'], // Suponiendo que alertas usan id_categoria
            [['id_etiqueta'], 'integer'],
        ];
    }

    public function search($params)
    {
        $query = Alerta::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // opcionalmente: $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'duracion_estimada' => $this->duracion_estimada,
            'id_lugar' => $this->id_lugar,
            'id_usuario' => $this->id_usuario,
            'id_ubicacion' => $this->id_ubicacion,
            'id_imagen' => $this->id_imagen,
            'id_categoria' => $this->id_categoria,
            'id_etiqueta' => $this->id_etiqueta,
        ]);

        $query->andFilterWhere(['like', 'titulo', $this->titulo])
              ->andFilterWhere(['like', 'descripcion', $this->descripcion])
              ->andFilterWhere(['like', 'estado', $this->estado]);

        return $dataProvider;
    }
}
