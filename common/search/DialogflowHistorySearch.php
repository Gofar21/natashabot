<?php

namespace common\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\DialogflowHistory;
use yii\db\Expression;

/**
 * DialogflowHistorySearch represents the model behind the search form of `common\models\DialogflowHistory`.
 */
class DialogflowHistorySearch extends DialogflowHistory
{
    public $tanggal;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [
                [
                    'insert_id', 'text_payload', 'resource', 'timestamp', 'receive_timestamp', 'log_name',
                    'trace', 'language', 'labels_type', 'labels_request_id', 'labels_protocol', 'severity',
                    'tanggal'
                ],
                'safe'
            ],
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
        $query = DialogflowHistory::find()
            ->distinct()
            ->select([
                "trace",
                'tanggal' => new Expression("date(timestamp)"),
                "jumlah" => new Expression("count(*)")
            ])
            ->groupBy([
                "trace",
                "date(timestamp)"
            ]);

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
            'timestamp' => $this->timestamp,
            'receive_timestamp' => $this->receive_timestamp,
            'date(timestamp)' => $this->tanggal
        ]);

        $query->andFilterWhere(['like', 'insert_id', $this->insert_id])
            ->andFilterWhere(['like', 'text_payload', $this->text_payload])
            ->andFilterWhere(['like', 'resource', $this->resource])
            ->andFilterWhere(['like', 'log_name', $this->log_name])
            ->andFilterWhere(['like', 'trace', $this->trace])
            ->andFilterWhere(['like', 'language', $this->language])
            ->andFilterWhere(['like', 'labels_type', $this->labels_type])
            ->andFilterWhere(['like', 'labels_request_id', $this->labels_request_id])
            ->andFilterWhere(['like', 'labels_protocol', $this->labels_protocol])
            ->andFilterWhere(['like', 'severity', $this->severity]);

        return $dataProvider;
    }
}
