<?php

namespace common\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Perawatan;

/**
 * PerawatanSearch represents the model behind the search form of `common\models\Perawatan`.
 */
class PerawatanSearch extends Perawatan
{
    public $keyword;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nama', 'keyword'], 'safe'],
            [['harga'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Perawatan::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'harga' => $this->harga,
        ]);

        $query->andFilterWhere(['like', 'nama', $this->nama]);
        $query->andFilterWhere(['like', 'nama', $this->keyword]);

        return $dataProvider;
    }
}
