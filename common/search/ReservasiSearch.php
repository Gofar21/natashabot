<?php

namespace common\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Reservasi;

/**
 * ReservasiSearch represents the model behind the search form of `common\models\Reservasi`.
 */
class ReservasiSearch extends Reservasi
{
    public $keyword;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pelanggan_id', 'perawatan_id', 'klinik_id', 'dokter_id'], 'integer'],
            [['tanggal', 'waktu', 'keyword'], 'safe'],
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
        $query = Reservasi::find()
            ->joinWith(['perawatan', 'pelanggan', 'dokter', 'klinik']);

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
            'pelanggan_id' => $this->pelanggan_id,
            'tanggal' => $this->tanggal,
            'waktu' => $this->waktu,
            'perawatan_id' => $this->perawatan_id,
            'klinik_id' => $this->klinik_id,
            'dokter_id' => $this->dokter_id,
        ]);

        $query->andFilterWhere([
            'or',
            ['like', 'perawatan.nama', $this->keyword],
            ['like', 'pelanggan.nama', $this->keyword],
            ['like', 'klinik.nama', $this->keyword],
            ['like', 'dokter.nama', $this->keyword],
        ]);

        return $dataProvider;
    }
}
