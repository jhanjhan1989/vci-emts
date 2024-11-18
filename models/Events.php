<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "events".
 *
 * @property int $id
 * @property string $name
 * @property string $date_from
 * @property string $date_to
 * @property string $description
 * @property int $is_active
 * @property int $is_deleted
 * @property int $is_publish
 * @property string $created_at
 * @property string $url
 * @property string|null $updated_at
 * @property int $author_id
 */
class Events extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'date_from', 'date_to', 'description'], 'required'],
            [['name', 'description', 'url'], 'string'],
            [['date_from', 'date_to', 'created_at', 'updated_at'], 'safe'],
            [['is_active', 'is_deleted', 'is_publish', 'author_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name of Event',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'description' => 'Description',
            'is_active' => 'Is Active',
            'url' => 'URL',
            'is_deleted' => 'Is Deleted',
            'is_publish' => 'Is Publish',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'author_id' => 'Author ID',
        ];
    }
    
}
