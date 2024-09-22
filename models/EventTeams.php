<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "event_teams".
 *
 * @property int $id
 * @property int $event_id
 * @property int $team_id
 * @property string $description
 * @property int $is_active
 * @property int $is_deleted
 * @property int $is_publish
 * @property string $created_at
 * @property string|null $updated_at
 * @property int $author_id
 */
class EventTeams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    
    public static function tableName()
    {
        return 'event_teams';
    }
    public $score;
    public $remarks;
    public $contestant;
    /**
     * {@inheritdoc}
     */
  
    public function rules()
    {
        return [
            [['event_id', 'team_id'  ], 'integer'], 
            [['description','team_id'  ], 'required'],
            [['description', 'remarks', 'contestant'], 'string'],
            [['score'], 'number'],
            [['created_at', 'updated_at', 'author_id', 'remarks'], 'safe'],
        ];
    }

   

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'team_id' => 'Team',
            'description' => 'Description',
            'is_active' => 'Is Active',
            'is_deleted' => 'Is Deleted',
            'is_publish' => 'Is Publish',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'author_id' => 'Author ID',
        ];
    }

    public function getTeams()
    {
        $query    = Teams::find()->where(['is_active' => 1, 'is_deleted'=>0]); 
        $ordered    = $query->orderBy('name')->all();
        $list = ArrayHelper::map($ordered, 'id', 'name');
        return $list;
    }

}
