<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "event_sports".
 *
 * @property int $id
 * @property int $event_id
 * @property int $sport_id
 * @property int $venue_id
 * @property float $max_score
 * @property string $description
 * @property int $is_active
 * @property int $is_deleted
 * @property int $is_publish
 * @property string $created_at
 * @property string|null $updated_at
 * @property int $author_id
 */
class EventSports extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'event_sports';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'sport_id', 'venue_id' ], 'integer'],
            [['max_score'], 'number'],
            [['description','sport_id', 'venue_id' ], 'required'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'author_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getEvents()
    {
        $query    = Events::find()->where(['is_active' => 1, 'is_deleted'=>0]); 
        $ordered    = $query->orderBy('name')->all();
        $list = ArrayHelper::map($ordered, 'id', 'name');
        return $list;
    }
     public function getSports()
    {
        $query    = Sports::find()->where(['is_active' => 1, 'is_deleted'=>0]); 
        $ordered    = $query->orderBy('name')->all();
        $list = ArrayHelper::map($ordered, 'id', 'name');
        return $list;
    }
    public function getVenues()
    {
        $query    = Venues::find()->where(['is_active' => 1, 'is_deleted'=>0]); 
        $ordered    = $query->orderBy('name')->all();
        $list = ArrayHelper::map($ordered, 'id', 'name');
        return $list;
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event Name',
            'sport_id' => 'Name of Sport / Competition',
            'venue_id' => 'Venue',
            'max_score' => 'Max Score / Points',
            'description' => 'Description',
            'is_active' => 'Is Active',
            'is_deleted' => 'Is Deleted',
            'is_publish' => 'Is Publish',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'author_id' => 'Author ID',
        ];
    }
}
