<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ogl_files".
 *
 * @property int $id
 * @property int $ogl_id
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
class OglFiles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ogl_files';
    }
    public $file_name_ext;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'description', 'title'], 'required'],
            [['ogl_id', 'file_size'], 'integer'],
            [['title', 'description', 'imageFile'], 'string'],
            [['created_at', 'updated_at', 'file_name', 'file_type', 'id', 'file_path', 'imageFile'], 'safe'],
          
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ogl_id' => 'Ogl ID',
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

   
    public function getFile_name_ext()
    {
        return  $this->file_name_ext = $this->file_name . '.' . $this->file_type;
    }
    public function has_Ogl(){
        return Ogl::findOne($this->ogl_id);
    }
}
