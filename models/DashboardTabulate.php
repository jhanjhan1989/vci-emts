<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dashboard_tabulate".
 *
 * @property int $event_id
 * @property string $event_name
 * @property string $sport_name
 * @property string $team_name
 * @property float $score
 */
class DashboardTabulate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dashboard_tabulate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id'], 'integer'],
            [['event_name', 'sport_name', 'team_name'], 'required'],
            [['event_name', 'sport_name', 'team_name'], 'string'],
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
            'event_name' => 'Event Name',
            'sport_name' => 'Sport Name',
            'team_name' => 'Team Name',
            'score' => 'Score',
        ];
    }
}
