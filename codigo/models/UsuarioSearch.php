<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class UsuarioSearch extends Usuario
{
    public $fecha_inicio;
    public $fecha_fin;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'email', 'fecha_inicio', 'fecha_fin'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Usuario::find();

        if (!empty($params['UsuarioSearch']['fecha_inicio']) && !empty($params['UsuarioSearch']['fecha_fin'])) {
            $query->andWhere(['between', 'created_at', $params['UsuarioSearch']['fecha_inicio'], $params['UsuarioSearch']['fecha_fin']]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'username', $this->username])
              ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
