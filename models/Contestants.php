<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "contestants".
 *
 * @property int $id
 * @property int $event_id
 * @property int $team_id
 * @property int $sport_id
 * @property string $name
 * @property int $is_active
 * @property int $is_deleted
 * @property int $author_id
 * @property string $remarks
 * @property string $created_at
 * @property string|null $updated_at
 */
class Contestants extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contestants';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_id', 'team_id', 'sport_id', 'remarks'], 'required'],
            [['event_id', 'team_id', 'sport_id', 'is_active', 'is_deleted', 'author_id'], 'integer'],
            [['remarks', 'name'], 'string'],
            [['created_at', 'updated_at', 'name'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_id' => 'Event ID',
            'team_id' => 'Team ID',
            'sport_id' => 'Sport ID',
            'name' => 'Name',
            'is_active' => 'Is Active',
            'is_deleted' => 'Is Deleted',
            'author_id' => 'Author ID',
            'remarks' => 'Remarks',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
