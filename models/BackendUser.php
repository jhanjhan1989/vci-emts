<?php

namespace app\models;

use Yii;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "backend_user".
 *
 * @property int $id
 * @property int $member_id
 * @property string $username
 * @property string $password
 * @property string $authKey
 * @property int $is_active
 * @property int $user_type
 * @property int $sector_id
 * @property int $agency_id
 * @property string $date_updated
 */
class BackendUser extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public $password_confirm;
    const SCENARIO_REGISTER = 'registration';
    const SCENARIO_PROFILEUPDATE = 'profileupdate';
    public static function tableName()
    {
        return 'backend_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username','is_active', 'date_updated','user_type','agency_id'], 'required'],
            [[ 'password','password_confirm'], 'required', 'except' => self::SCENARIO_PROFILEUPDATE],
          
            [['member_id','is_active','user_type','sector_id','agency_id'], 'integer'],
            [['username'],'unique'],
            [['date_updated'], 'safe'],
            ['password', 'string', 'skipOnEmpty' => true,'min' => 5,  'message' => '{attribute} should be at least 6 characters',  'except' => self::SCENARIO_PROFILEUPDATE],
            [
                'password_confirm', 'compare', 'compareAttribute' => 'password',
                'message' => "Passwords don't match", 'on' => self::SCENARIO_REGISTER,
            ],
            [
                'password_confirm', 'compare', 'compareAttribute' => 'password', 'skipOnError' => false,
                'message' => "Passwords don't match", 'on' => self::SCENARIO_PROFILEUPDATE,
            ],
           
            [['username', 'password', 'password_confirm','authKey'], 'string', 'max' => 100],
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
            'password_confirm' => 'Confirm Password',
            'authKey' => 'Auth Key',
            'is_active' => 'Is Active',
            'date_updated' => 'Date Updated',
        ];
    }

    /**
     * @inheritDoc
     */
    public static function findIdentity($id)
    {
       return self::findOne($id);
    }

    /**
     * @inheritDoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
        throw new NotSupportedException();
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritDoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    public static function findByUsername($username){
//        return self::findOne(['username'=>$username,'is_active'=>1]);
        return self::find()->where(['username'=>$username])
            ->andWhere(['is_active'=>[1,2,3]])->one(); // allow login of active and inactive members

//        return self::find()->where('id != :id and type != :type', ['id'=>1, 'type'=>1])->one();
    }

    public function validatePassword($password){
        return $this->password === $password;
    }

    public function getMember()
    {
        return $this->hasOne(Member::className(), ['member_id' => 'member_id']);
    }

}
