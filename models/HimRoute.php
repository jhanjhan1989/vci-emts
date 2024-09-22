<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "him_route".
 *
 * @property int $id
 * @property string $route_date
 * @property int|null $him_id
 * @property string|null $from_staff
 * @property string $to_staff
 * @property string $instructions
 * @property string $action_taken
 * @property string $created_at
 * @property string|null $updated_at
 * @property int $author_id
 */
class HimRoute extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'him_route';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['to_staff', 'instructions'], 'required'],
            [['route_date', 'created_at', 'updated_at'], 'safe'],
            [['him_id', 'author_id'], 'integer'],
            [['from_staff', 'to_staff', 'instructions', 'action_taken'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'route_date' => 'Date',
            'him_id' => 'Him ID',
            'from_staff' => 'Origin',
            'to_staff' => 'Forwarded To',
            'instructions' => 'Instructions / Actions',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'author_id' => 'Author ID',
        ];
    }
}
