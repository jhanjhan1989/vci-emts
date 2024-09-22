<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "him_files".
 *
 * @property int $id
 * @property int $him_id
 * @property string|null $title
 * @property string $description
 * @property string $imageFile
 * @property string $file_name
 * @property string $file_type
 * @property int $file_size
 * @property string $file_path
 * @property string $created_at
 * @property string|null $updated_at
 */
class HimFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'him_files';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'description', 'title'], 'required'],
            [['him_id', 'file_size'], 'integer'],
            [['title', 'description', 'imageFile'], 'string'],
            [['created_at', 'updated_at', 'file_name', 'file_type', 'id', 'file_path', 'imageFile'], 'safe'],
            [['file_name', 'file_path'], 'string', 'max' => 100],
            [['file_type'], 'string', 'max' => 45],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'him_id' => 'Him ID',
            'title' => 'Title',
            'description' => 'Description',
            'imageFile' => 'Image File',
            'file_name' => 'File Name',
            'file_type' => 'File Type',
            'file_size' => 'File Size',
            'file_path' => 'File Path',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function has_Him(){
        return Him::findOne($this->him_id);
    }
}
