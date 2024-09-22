<?php

namespace app\models;
use app\models\BackendUser;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "member".
 *
 * @property int $member_id
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $birth_date
 * @property string $prc_exp_date
 * @property string $prc_id
 * @property string $email
 * @property string $profile_pic
 * @property string $contact_number
 * @property int $status
 * @property int $membership_type
 * @property int $sex
 * @property string $occupation
 * @property string $affiliation
 * @property string $date_updated
 * @property string $scenario_tag
 * 
 */
class Member extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */ 
     
    const SCENARIO_FORGOT_PASSWORD = 'forgotpassword';
    const SCENARIO_UPDATE_CONTACT_INFO = 'updateContactInfo';
    public $scenario_tag;
    public $file_prc;
    public $file_cv;
    public $imageFile;
    public $prc_exp_date; 
    public $user_role;
    public static function tableName()
    {
        return 'member';
    }

    public function getfullName()
    {
        return ucwords($this->lastname.', '.$this->firstname);
    }

    public function checkVisibility($field,$value,$fieldname=''){
        if(!Yii::$app->user->isGuest && Yii::$app->user->identity->user_type == 1){
            if($fieldname=='sex'){
                if($value==1)
                    return 'Male';
                else  if($value==2)
                    return 'Female';
                else   
                    return '--';
            }
            else{
                return $value; 
            }
        }
        else{
            if($field){//if set to visible, return value; else return ***
                if($fieldname=='sex'){
    
                    if($value==1)
                        return 'Male';
                    else  if($value==2)
                        return 'Female';
                    else   
                        return '--';
                }
                else{
                    return $value; 
                }
            }
            else{
                return "****";
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        /*error message will be prompted if condition is not met. if email is not greater than 0, throw error
         * 
         */
        return [
            [[ 'firstname', 'lastname','email' ], 'required','except' => self::SCENARIO_FORGOT_PASSWORD], 
            [[ 'email','contact_number',  ], 'required','on' => self::SCENARIO_UPDATE_CONTACT_INFO], 
            [['file_prc','file_cv'], 'file', 'extensions' => 'png,jpg,jpeg,pdf'],
            [
                'email', 'compare', 'compareValue' => '0','operator'=>'>',
                'message' => "Email not found.", 'on' => self::SCENARIO_FORGOT_PASSWORD,
            ],
            [['email'],'unique','except' => self::SCENARIO_FORGOT_PASSWORD],
  
            [['status', 'membership_type','sex'   ], 'integer'],
            [['date_updated','birth_date', 'scenario_tag' ], 'safe'],
            ['email', 'email'],
            [['firstname', 'middlename', 'lastname', 'occupation' ,'contact_number', ], 'string', 'max' => 50],
            [['profile_pic','scenario_tag'], 'string', 'max' => 300],
            [['occupation'], 'string', 'max' => 100], 
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'member_id' => 'Member ID',
            'reg_hash' => 'Registration Key',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'lastname' => 'Lastname',
            'prc_id' => 'Prc ID',
            'prc_exp_date'=>'Expiration Date',
            'status' => 'Status',
            'date_updated' => 'Date Updated', 
            'address1'=>'House #, Street Name, Brgy.', 
            'is_qualified_for_lm'=>'Qualified for Lifetime Membership?',
        ];
    }

    public function getBackendUser()
    {
        return $this->hasOne(BackendUser::class, ['member_id' => 'member_id']);
    }

    
}
