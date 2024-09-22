<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "venues".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $is_active
 * @property int $is_deleted
 * @property string $created_at
 * @property string|null $updated_at
 * @property int $author_id
 */
class Venues extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'venues';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['name', 'description'], 'string'],
            [['author_id'], 'integer'],
            [['created_at', 'updated_at', 'author_id', 'is_deleted', 'is_active'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Venue Name',
            'description' => 'Description',
            'is_active' => 'Is Active',
            'is_deleted' => 'Is Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'author_id' => 'Author ID',
        ];
    }
}
