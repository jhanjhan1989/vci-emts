<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\HimRoute;

/**
 * HimRouteSearch represents the model behind the search form of `app\models\HimRoute`.
 */
class HimRouteSearch extends HimRoute
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'him_id', 'author_id'], 'integer'],
            [['route_date', 'from_staff', 'to_staff', 'instructions', 'action_taken', 'due_date', 'created_at', 'updated_at'], 'safe'],
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
        $query = HimRoute::find();

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
            'route_date' => $this->route_date,
            'him_id' => $this->him_id,
            'due_date' => $this->due_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'author_id' => $this->author_id,
        ]);

        $query->andFilterWhere(['like', 'from_staff', $this->from_staff])
            ->andFilterWhere(['like', 'to_staff', $this->to_staff])
            ->andFilterWhere(['like', 'instructions', $this->instructions])
            ->andFilterWhere(['like', 'action_taken', $this->action_taken]);

        return $dataProvider;
    }
}
