<?php

namespace app\controllers;

use app\models\Agency;
use app\models\BackendUser;
use app\models\SectorAgencies;
use Yii;
use app\models\Member;
use app\models\CertDownload;
use app\models\UploadForm;
use app\models\MemberSearch;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Expression;
use app\models\MemberList;
use app\models\ActivityLog;
use app\models\Item;
use app\models\Material;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

use kartik\mpdf\Pdf;

/**
 * MemberController implements the CRUD actions for Member model.
 */
class MemberController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['view', 'update', 'delete', 'index', 'create'],
                'rules' => [
                    [
                        'actions'       => ['update', 'delete', 'create', 'index'],
                        'allow'         => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest && (Yii::$app->user->identity->user_type == 1 || Yii::$app->user->identity->user_type == 2));
                        }
                    ],
                    [
                        'actions' => ['view', 'update', 'index', 'create'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Member models.
     * @return mixed
     */
    public function actionIndex()
    {

        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->user_type == 3) {
            throw new MethodNotAllowedHttpException('Action not allowed!');
        }

        $searchModel = new MemberSearch();
        if (Yii::$app->user->isGuest) {//if guest is viewing, show only active members
            $searchModel->status = 1;
        }
        $dataProvider                       = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 20;
       

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider, 
        ]);
    }

    
    /**
     * Displays a single Member model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->user->isGuest) {
            $mem = $this->findModel($id);
            if ($mem->status != 1) {
                throw new MethodNotAllowedHttpException('Action not allowed! Only active members\' profile can be viewed.');
            }
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionViewRegister($id)
    {
        if (!empty (Yii::$app->session->get('regUser')))
            $session_id = Yii::$app->session->get('regUser');
        else
            $session_id = 0;
        return $this->render('viewRegister', [
            'model' => $this->findModel($session_id),
        ]);
    }
    /**
     * Creates a new Member model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    /**
     * Creates a new Member model  .
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    function getMembershipType($type)
    {
        if ($type == 'RM') {
            return 1;
        } else if ($type == 'AM') {
            return 2;
        } else if ($type == 'SM') {
            return 5;
        } else if ($type == 'LM') {
            return 4;
        }

    }

    public function actionRenew()
    {
        $model = new Member();
        return $this->render('renew', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model      = new Member();
        $modelUser  = new BackendUser(['scenario' => 'registration']);
        $connection = Yii::$app->db;

        $transaction = $connection->beginTransaction(); 

        try {
            if ($model->load(Yii::$app->request->post()) && $modelUser->load(Yii::$app->request->post())) {

                $model->date_updated    = date("Y-m-d h:i:s");
                $model->status          = 1;
                $model->membership_type = $modelUser->user_type;
                $isValid                = $model->validate();
                
                $modelUser->date_updated = date("Y-m-d h:i:s");
                $modelUser->is_active    = 1;
                $modelUser->agency_id = 0;
                $isValid = $modelUser->validate() && $isValid;
                // return print_r($modelUser);
                if ($isValid) {
                    $model->save();
                    $modelUser->member_id = $model->member_id;
                 
                    $modelUser->password  = Yii::$app->security->generatePasswordHash($modelUser->password);
                    $modelUser->save(false);

                    Yii::$app->session->set('regUser', $model->member_id);
                    $transaction->commit();

                    Yii::$app->getSession()->setFlash('success', [
                        'text'              => 'Member Info Saved.',
                        'title'             => 'Success!',
                        'type'              => 'success',
                        'timer'             => 3000,
                        'showConfirmButton' => false
                    ]);
                    return $this->redirect(['view', 'id' => $model->member_id]);
                } else {
                    throw new Exception('Error creating member record.');
                }
            }
        } catch (Exception $e) {
            // echo "--".$e->getMessage();
            // die();
            Yii::$app->getSession()->setFlash('success', [
                'text'              => 'Unable to register:' . $e->getMessage(),
                'title'             => 'Error!',
                'type'              => 'error',
                'timer'             => 3000,
                'showConfirmButton' => false
            ]);
            $transaction->rollback();
        }

        return $this->render('create', [
            'model'     => $model,
            'modelUser' => $modelUser,
        ]);
    }

    public function actionUpdate($id)
    {
        

        $model               = $this->findModel($id);
        $modelUser           = BackendUser::findOne(['member_id' => $id]);
        $modelUser->scenario = 'profileupdate';
        $currentPw           = $modelUser->password;
        $connection          = \Yii::$app->db;
        
        $transaction         = $connection->beginTransaction();
        try {
            if ($model->load(Yii::$app->request->post()) && $modelUser->load(Yii::$app->request->post())) {
                $model->date_updated = date("Y-m-d h:i:s");
                // $model->status= 1;
                $isValid = $model->validate();

                $modelUser->date_updated = date("Y-m-d h:i:s");
                $modelUser->is_active    = 1;

                $isValid = $modelUser->validate() && $isValid;
                if ($isValid) {
                    $model->save();
                    $modelUser->member_id = $model->member_id;

                    $backEndUser   = Yii::$app->request->post('BackendUser');
                    $postPw        = $backEndUser['password'];
                    $postPwConfirm = $backEndUser['password_confirm'];

                    if ($postPw == '' && $postPwConfirm == '') {//use current password if pw and confirm are unchanged
                        $modelUser->password         = $currentPw;
                        $modelUser->password_confirm = $currentPw;
                    } else {//if pws are changed, check if the same
                        if (strlen($postPw) < 5) {
                            $modelUser->password = $postPw;
                            throw new Exception('Password should contain at least 5 characters.');
                        } else {
                            if ($postPw === $postPwConfirm) {
                                $modelUser->password         = Yii::$app->security->generatePasswordHash($postPw);
                                $modelUser->password_confirm = $modelUser->password;
                            } else {
                                $modelUser->password         = $postPw;
                                $modelUser->password_confirm = $postPwConfirm;
                                throw new Exception('Passwords did not match');
                            }
                        }
                    }
                    $modelUser->save(false);

                    Yii::$app->session->set('regUser', $model->member_id);
                    $transaction->commit();

                    Yii::$app->getSession()->setFlash('success', [
                        'text'              => 'Member info updated.',
                        'title'             => 'Success!',
                        'type'              => 'success',
                        'timer'             => 3000,
                        'showConfirmButton' => false
                    ]);

                    return $this->redirect(['view', 'id' => $model->member_id]);
                } else {
                    throw new Exception('Unable to save record.');
                }
            }

        } catch (Exception $e) {
            // echo $e->getMessage();
            // die();

            Yii::$app->getSession()->setFlash('success', [
                'text'              => 'Unable to create member account: ' . $e->getMessage(),
                'title'             => 'Error!',
                'type'              => 'error',
                'timer'             => 3000,
                'showConfirmButton' => false
            ]);
            $transaction->rollback();
        }

        return $this->render('update', [
            'model'     => $model,
            'modelUser' => $modelUser
        ]);
    }


    public function actionProfilePicture($id)
    {
        if ($id != Yii::$app->user->identity->member_id) {
            throw new MethodNotAllowedHttpException('Action not allowed!');
        }

        $model       = new UploadForm();
        $modelMember = Member::findOne(['member_id' => $id]);
        if (Yii::$app->request->isPost) {
            $model->imageFile = \yii\web\UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload($id)) {
                // file is uploaded successfully
                if ($modelMember) {
                    if ($modelMember->profile_pic)
                        //     unlink($modelMember->profile_pic);

                        $path = 'uploads/profile/' . $id;
                    $modelMember->profile_pic = $path . '/' . $model->imageFile->baseName . '-' . date("Y-m-d") . '.' . $model->imageFile->extension;
                    $modelMember->save(false);
                    return $this->redirect(['member/view', 'id' => $id]);
                } else {
                    throw new Exception('No user record found.');
                }
            } else {
                throw new Exception('Unable to save record.');
            }

        }


        return $this->render('updateProfilePic', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Member model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    public function logActivity($id, $action, $cat, $changes)
    {
        $log           = new ActivityLog();
        $log->category = $cat;//1 =member, 2= payment
        if ($cat == 2) {
            $log->member_id  = 0;
            $log->payment_id = $id;
        } else {
            $log->member_id  = $id;
            $log->payment_id = 0;
        }
        $log->action  = $action;//1 create, 2 update, 3 delete
        $log->author  = Yii::$app->user->identity->member_id;
        $log->changes = $changes;

        $log->date_updated = date("Y-m-d h:i:s");
        if ($log->save()) {
            return true;
        } else {
            print_r($log->getErrors());
            die();
            throw new CHttpException(404, 'The requested page does not exist.');
        }
    }

    /**
     * Deletes an existing Member model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->member_id == $id) {
            throw new MethodNotAllowedHttpException('Action not allowed!');
        }

        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->user_type !== 1) {
            if (!Yii::$app->user->isGuest && Yii::$app->user->identity->user_type == 2) {
                $modelUser = BackendUser::findOne(['member_id' => $id]);
                if ($modelUser && $modelUser->user_type == 1) {// throw error if trying to delete super admin
                    throw new MethodNotAllowedHttpException('Action not allowed! Super Admin can only be updated by another super admin.');
                } else {
                    if ($modelUser && $modelUser->sector_id != Yii::$app->user->identity->sector_id) { // throw error if trying to delete member from another sector
                        throw new MethodNotAllowedHttpException('Action not allowed! Sector admin can only update respective sector member accounts.');
                    }
                }
            }
        }
        $this->findModel($id)->delete();
        $backend = BackendUser::findOne(['member_id' => $id]);
        if ($backend) {
            $backend->delete();
        }
        Yii::$app->getSession()->setFlash('success', [
            'text'              => 'Member data deleted',
            'title'             => 'Success!',
            'type'              => 'success',
            'timer'             => 3000,
            'showConfirmButton' => false
        ]);
        return $this->redirect(['index']);
    }


    /**
     * Finds the Member model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Member the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Member::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


}
