<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\ogl;

/**
 * OglSearch represents the model behind the search form of `app\models\ogl`.
 */
class OglSearch extends ogl
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'control_no', 'author_id'], 'integer'],
            [['control_date', 'staff_responsible', 'reference_gil', 'stakeholder', 'position', 'organization', 'purpose', 'status', 'date_released', 'created_at', 'updated_at'], 'safe'],
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
        $query = ogl::find();

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
            'control_date' => $this->control_date,
            'control_no' => $this->control_no,
            'date_released' => $this->date_released,
            'author_id' => $this->author_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'staff_responsible', $this->staff_responsible])
            ->andFilterWhere(['like', 'reference_gil', $this->reference_gil])
            ->andFilterWhere(['like', 'stakeholder', $this->stakeholder])
            ->andFilterWhere(['like', 'position', $this->position])
            ->andFilterWhere(['like', 'organization', $this->organization])
            ->andFilterWhere(['like', 'purpose', $this->purpose])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
