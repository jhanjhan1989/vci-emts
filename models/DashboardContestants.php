<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dashboard_contestants".
 *
 * @property int $event_id
 * @property int $sport_id
 * @property int $team_id
 * @property string $event_name
 * @property string $sport_name
 * @property string $team_name
 * @property string $department
 * @property float $score
 * @property string $remarks
 */
class DashboardContestants extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dashboard_contestants';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'sport_id', 'team_id'], 'integer'],
            [['event_name', 'sport_name', 'team_name', 'department', 'remarks'], 'required'],
            [['event_name', 'sport_name', 'team_name', 'department', 'remarks'], 'string'],
            [['score'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'event_id' => 'Event ID',
            'sport_id' => 'Sport ID',
            'team_id' => 'Team ID',
            'event_name' => 'Event Name',
            'sport_name' => 'Sport Name',
            'team_name' => 'Team Name',
            'department' => 'Department',
            'score' => 'Score',
            'remarks' => 'Remarks',
        ];
    }
}
