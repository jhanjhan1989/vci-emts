<?php
namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png,jpg,jpeg'],
        ];
    }
    
    public function upload($id)
    {
        if ($this->validate()) {
            $path = 'uploads/profile/'.$id;
            FileHelper::createDirectory($path, $mode = 0775, $recursive = true);
            $this->imageFile->saveAs($path.'/'.$this->imageFile->baseName.'-'.date("Y-m-d"). '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}