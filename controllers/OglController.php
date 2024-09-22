<?php

namespace app\controllers;

use app\models\Model;
use app\models\ogl;
use app\models\OglFiles;
use app\models\OglSearch;
use Exception;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OglController implements the CRUD actions for ogl model.
 */
class OglController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all ogl models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new OglSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ogl model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ogl model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $attachments = [new OglFiles()];
        if (!Yii::$app->user->isGuest) {

            $model = new ogl([
                "author_id" => Yii::$app->user->identity->id,
                "created_at" => date("Y-m-d H:i:s")
            ]);

            if ($model->load($this->request->post()) && $model->save()) {
                $attachments = Model::createMultiple(OglFiles::classname());
                Model::loadMultiple($attachments, Yii::$app->request->post());
                $valid = Model::validateMultiple($attachments);
                if ($valid) {
                    OglFiles::deleteAll(['ogl_id' => $model->id]);
                    foreach ($attachments as $index => $item) {
                        $client_img   = $_FILES['OglFiles']['name'][$index]['imageFile'];
                        $explode_file = explode('.', $client_img);
                        $ext          = end($explode_file);
                        $tmpImg       = $_FILES['OglFiles']['tmp_name'][$index]['imageFile'];
                        $coverName    = Yii::$app->security->generateRandomString();
                        if ($item->ogl_id == null) { //if new entry
                            if ($client_img != '') {
                                $coverName = Yii::$app->security->generateRandomString();
                                if (move_uploaded_file($tmpImg, 'ogl/' . $coverName . '.' . $ext)) {
                                    $item->file_path = 'ogl/' . $coverName . '.' . $ext;
                                    $item->file_name = substr($client_img, 0, strrpos($client_img, "."));
                                    $item->file_type = $ext;
                                    $item->file_size = filesize($item->file_path);
                                }
                            } else {
                                $item->file_size = 0;
                            }
                            $item->ogl_id   = $model->id;
                            $item->created_at = $item->created_at?  $item->created_at : date("Y-m-d H:i:s");
                            $item->updated_at = date("Y-m-d h:i:s");
                            $item->imageFile    = 'true';
                            $item->save(true);
                        } else { //new entry
                            $item->updated_at = date("Y-m-d h:i:s");
                            $item->save(false);
                        }
                    }
                   
                } 
                else{
                    return print 'Not a valid entry';
                }
                Yii::$app->getSession()->setFlash('success', [
                    'text'              => 'Content Info Saved.',
                    'title'             => 'Success!',
                    'type'              => 'success',
                    'timer'             => 3000,
                    'showConfirmButton' => false
                ]);
                return $this->redirect(['view', 'id' => $model->id]); 
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                'model' => $model,
                'attachments' => $attachments
            ]);
        }
    }
    /**
     * Updates an existing ogl model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $attachments = OglFiles::find()->where(['ogl_id' => $model->id])->all();
        if (!$attachments)  $attachments = [new OglFiles()]; 
        $connection  = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                $attachments = Model::createMultiple(OglFiles::classname());
                Model::loadMultiple($attachments, Yii::$app->request->post());
                $valid = Model::validateMultiple($attachments);
                if ($model->validate() && $model->save()) {
                  
                    if ($valid) {
                        OglFiles::deleteAll(['ogl_id' => $model->id]);
                        foreach ($attachments as $index => $item) {
                            $client_img   = $_FILES['OglFiles']['name'][$index]['imageFile'];
                            $explode_file = explode('.', $client_img);
                            $ext          = end($explode_file);
                            $tmpImg       = $_FILES['OglFiles']['tmp_name'][$index]['imageFile'];
                            $coverName    = Yii::$app->security->generateRandomString();
                            if ($item->ogl_id == null) { //if new entry
                                if ($client_img != '') {
                                    $coverName = Yii::$app->security->generateRandomString();
                                    if (move_uploaded_file($tmpImg, 'ogl/' . $coverName . '.' . $ext)) {
                                        $item->file_path = 'ogl/' . $coverName . '.' . $ext;
                                        $item->file_name = substr($client_img, 0, strrpos($client_img, "."));
                                        $item->file_type = $ext;
                                        $item->file_size = filesize($item->file_path);
                                    }
                                } else {
                                    $item->file_size = 0;
                                }
                                $item->ogl_id   = $model->id;
                                $item->created_at = $item->created_at?  $item->created_at : date("Y-m-d H:i:s");
                                $item->updated_at = date("Y-m-d H:i:s");
                                $item->imageFile    = 'true';
                                $item->save(true);
                            } else { //new entry
                                $item->updated_at = date("Y-m-d H:i:s");
                                $item->save(false);
                            }
                        }
                       
                    } else {
                        return print 'test';
                    }
                    Yii::$app->getSession()->setFlash('success', [
                        'text'              => 'Content Info Saved.',
                        'title'             => 'Success!',
                        'type'              => 'success',
                        'timer'             => 3000,
                        'showConfirmButton' => false
                    ]);

                    $transaction->commit();
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->getSession()->setFlash('error', [
                        'text'              => 'Kindly select a valid file.',
                        'title'             => 'Error!',
                        'type'              => 'error',
                        'timer'             => 3000,
                        'showConfirmButton' => false
                    ]);
                    return $this->render('update', [
                        'model' => $model,
                        'attachments' => $attachments
                    ]);
                }

                return $this->redirect(['view', 'id' => $model->id]);
            }
        } catch (Exception $e) {
            return print $e;
            Yii::$app->getSession()->setFlash('success', [
                'text'              => 'Unable to create member account.',
                'title'             => 'Error!',
                'type'              => 'error',
                'timer'             => 3000,
                'showConfirmButton' => false
            ]);
            $transaction->rollback();
        }
        return $this->render('update', [
            'model' => $model,
            'attachments' => $attachments
        ]);
    }

    /**
     * Deletes an existing ogl model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ogl model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return ogl the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ogl::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
