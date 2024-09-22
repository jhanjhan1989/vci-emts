<?php

namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use app\models\Member;

/**
 * MemberSearch represents the model behind the search form of `app\models\Member`.
 */
class MemberSearch extends Member
{
    /**
     * {@inheritdoc}
     */

    public $sector;
    public $agency;

    public function rules()
    {
        return [
            [['member_id', 'status','membership_type', 'sector', 'agency'], 'integer'],
            [[ 'firstname', 'middlename', 'lastname', 'prc_id', 'date_updated','membership_type','sector' ], 'safe'],
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
        
        $query = Member::find();
        $query->joinWith(['backendUser']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'lastname' => SORT_ASC, 
                ]
            ],
          
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->user_type == 2){
            $sector = Yii::$app->user->identity->sector_id; 
        }else{
            $sector  = $this->sector;
        }
       


        // grid filtering conditions
        $query->andFilterWhere([
            'member_id' => $this->member_id,
            'status' => $this->status,
            'membership_type' => $this->membership_type,
            'date_updated' => $this->date_updated,  
            'backend_user.sector_id' =>  $sector,
            'backend_user.agency_id' => $this->agency,
        ]);

        $null = new Expression('NULL');
  
        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'lastname', $this->lastname]) ;

        return $dataProvider;
    }

    public function searchGroupMembers($params)
    {
        
        $query = Member::find() 
        ->leftJoin('group_members','`group_members`.`member_id` = `member`.`member_id`')
        ->where(['is', 'group_members.member_id', null]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'lastname' => SORT_ASC, 
                ]
            ],
          
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
      
        // grid filtering conditions
        $query->andFilterWhere([
            'member_id' => $this->member_id,
            'status' => $this->status,
            'membership_type' => $this->membership_type,
            'date_updated' => $this->date_updated,  
        ]);

        $null = new Expression('NULL');
       
  
        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'prc_id', $this->prc_id]);

        return $dataProvider;
    }

    
    public function searchActive($params)
    {
        
        $query = Member::find()
        ->where('status = 1 or status = 3');

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
            'member_id' => $this->member_id,
            'status' => $this->status,
            'membership_type' => $this->membership_type,
            'date_updated' => $this->date_updated,
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'prc_id', $this->prc_id]);

        return $dataProvider;
    }
    
    public function searchInactive($params)
    {
        $query = Member::find()
        ->where('status = 2 or status = 4');
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
            'member_id' => $this->member_id,
            'status' => $this->status,
            'membership_type' => $this->membership_type,
            'date_updated' => $this->date_updated,
        
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'prc_id', $this->prc_id]);

        return $dataProvider;
    }

    public function searchForVerification($params)
    {
        $query = Member::find()
        ->where('for_verification = 1');
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
            'member_id' => $this->member_id,
            'status' => $this->status,
            'membership_type' => $this->membership_type,
            'date_updated' => $this->date_updated, 
        ]);

        $query->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'prc_id', $this->prc_id]);

        return $dataProvider;
    }
}
