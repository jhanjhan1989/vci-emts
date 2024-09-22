<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "score_card".
 *
 * @property int $id
 * @property int $event_id
 * @property int $team_id
 * @property int $sport_id
 * @property int $contestant_id
 * @property float $score
 * @property int $is_active
 * @property int $is_deleted
 * @property int $author_id
 * @property string $created_at
 * @property string|null $updated_at
 * @property string $remarks
 */
class ScoreCard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'score_card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'team_id', 'sport_id', 'score'], 'required'],
            [['event_id', 'team_id', 'sport_id', 'contestant_id', 'is_active', 'is_deleted', 'author_id'], 'integer'],
            [['score'], 'number'],
            [['created_at', 'updated_at', 'remarks'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event Name',
            'team_id' => 'Team',
            'sport_id' => 'Name of Sport / Competition',
            'contestant_id' => 'Contestant',
            'score' => 'Score',
            'is_active' => 'Is Active',
            'is_deleted' => 'Is Deleted',
            'author_id' => 'Author ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'remarks' => 'Remarks',
        ];
    }
   
}
