<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property string|null $authKey
 * @property int|null $user_type
 * @property int $is_active
 * @property string $updated_at
 * @property string $created_at
 *
 * @property UserType $userType
 */
class UserTable extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'is_active', 'updated_at'], 'required'],
            [['user_type', 'is_active'], 'integer'],
            [['updated_at', 'created_at'], 'safe'],
            [['username', 'password', 'authKey'], 'string', 'max' => 100],
            [['user_type'], 'exist', 'skipOnError' => true, 'targetClass' => UserType::class, 'targetAttribute' => ['user_type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'user_type' => 'User Type',
            'is_active' => 'Is Active',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[UserType]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserType()
    {
        return $this->hasOne(UserType::class, ['id' => 'user_type']);
    }
}
