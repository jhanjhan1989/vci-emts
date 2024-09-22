<?php

namespace app\controllers;

use app\models\him;
use app\models\HimFiles;
use app\models\HimRoute;
use app\models\HimSearch;
use app\models\Model;
use Exception;
use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HimController implements the CRUD actions for him model.
 */
class HimController extends Controller
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
     * Lists all him models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new HimSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single him model.
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
     * Creates a new him model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $attachments = [new HimFiles()];
        $route_history= [new HimRoute()];
        if (!Yii::$app->user->isGuest) {

            $model = new him([
                "author_id" => Yii::$app->user->identity->id,
                "created_at" => date("Y-m-d H:i:s")
            ]);

            if ($this->request->isPost) {
                if ($model->load($this->request->post()) && $model->save()) {
                    $attachments = Model::createMultiple(HimFiles::classname());
                    Model::loadMultiple($attachments, Yii::$app->request->post());
                    $valid = Model::validateMultiple($attachments);

                    $route_history = Model::createMultiple(HimRoute::classname());
                    Model::loadMultiple($route_history, Yii::$app->request->post());
                    $valid_route = Model::validateMultiple($route_history);

                    if ($model->validate() && $model->save()) {
                        //save attachments
                        if ($valid) {
                            HimFiles::deleteAll(['him_id' => $model->id]);
                            foreach ($attachments as $index => $item) {
                                $client_img   = $_FILES['HimFiles']['name'][$index]['imageFile'];
                                $explode_file = explode('.', $client_img);
                                $ext          = end($explode_file);
                                $tmpImg       = $_FILES['HimFiles']['tmp_name'][$index]['imageFile'];
                                $coverName    = Yii::$app->security->generateRandomString();
                                if ($item->him_id == null) { //if new entry
                                    if ($client_img != '') {
                                        $coverName = Yii::$app->security->generateRandomString();
                                        if (move_uploaded_file($tmpImg, 'files/' . $coverName . '.' . $ext)) {
                                            $item->file_path = 'files/' . $coverName . '.' . $ext;
                                            $item->file_name = substr($client_img, 0, strrpos($client_img, "."));
                                            $item->file_type = $ext;
                                            $item->file_size = filesize($item->file_path);
                                        }
                                    } else {
                                        $item->file_size = 0;
                                    }
                                    $item->him_id   = $model->id;
                                    $item->created_at = date("Y-m-d H:i:s");
                                    $item->imageFile    = 'true';
                                    $item->save(true);
                                } else { //new entry
                                    $item->created_at = date("Y-m-d H:i:s");
                                    $item->save(false);
                                }
                            }
                        } else {
                            return print 'Error in saving';
                        }
                        Yii::$app->getSession()->setFlash('success', [
                            'text'              => 'Content Info Saved.',
                            'title'             => 'Success!',
                            'type'              => 'success',
                            'timer'             => 3000,
                            'showConfirmButton' => false
                        ]);
                        if ($valid_route) {
                            HimRoute::deleteAll(['him_id' => $model->id]);
                            foreach ($route_history as $index => $item) {
                                $item->created_at = date("Y-m-d H:i:s");
                                $item->author_id = Yii::$app->user->identity->id;
                                if ($item->him_id == null) { 
                                    $item->him_id   = $model->id; 
                                    $item->save(true);
                                } else { //new entry 
                                    $item->save(false);
                                }
                            }
                        } else {
                            return print 'Error in saving';
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
                        Yii::$app->getSession()->setFlash('error', [
                            'text'              => 'Kindly select a valid file.',
                            'title'             => 'Error!',
                            'type'              => 'error',
                            'timer'             => 3000,
                            'showConfirmButton' => false
                        ]);
                        return $this->render('update', [
                            'model' => $model,
                            'attachments' => $attachments,
                            'route_history'=>$route_history
                        ]);
                    }

                    return $this->redirect(['view', 'id' => $model->id]);
                }
            } else {
                $model->loadDefaultValues();
            }

            return $this->render('create', [
                'model' => $model,
                'attachments' => $attachments,
                'route_history'=>$route_history
            ]);
        }
    }

    /**
     * Updates an existing him model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $attachments = HimFiles::find()->where(['him_id' => $model->id])->all();
        $route_history= HimRoute::find()->where(['him_id'=>$model->id])->all();
        if (!$attachments)  $attachments = [new HimFiles()];
        if (!$route_history)  $route_history = [new HimRoute()];
        $connection  = Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {

            if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
                $attachments = Model::createMultiple(HimFiles::classname());
                Model::loadMultiple($attachments, Yii::$app->request->post());
                $valid = Model::validateMultiple($attachments);
                $route_history = Model::createMultiple(HimRoute::classname());
                Model::loadMultiple($route_history, Yii::$app->request->post());
                $valid_route = Model::validateMultiple($route_history);

                if ($model->validate() && $model->save()) {
                    if ($valid) {
                        HimFiles::deleteAll(['him_id' => $model->id]);
                        foreach ($attachments as $index => $item) {
                            $client_img   = $_FILES['HimFiles']['name'][$index]['imageFile'];
                            $explode_file = explode('.', $client_img);
                            $ext          = end($explode_file);
                            $tmpImg       = $_FILES['HimFiles']['tmp_name'][$index]['imageFile'];
                            $coverName    = Yii::$app->security->generateRandomString();
                            if ($item->him_id == null) { //if new entry
                                if ($client_img != '') {
                                    $coverName = Yii::$app->security->generateRandomString();
                                    if (move_uploaded_file($tmpImg, 'files/' . $coverName . '.' . $ext)) {
                                        $item->file_path = 'files/' . $coverName . '.' . $ext;
                                        $item->file_name = substr($client_img, 0, strrpos($client_img, "."));
                                        $item->file_type = $ext;
                                        $item->file_size = filesize($item->file_path);
                                    }
                                } else {
                                    $item->file_size = 0;
                                }
                                $item->him_id   = $model->id;
                                $item->updated_at = date("Y-m-d h:i:s");
                                $item->imageFile    = 'true';
                                $item->created_at = date("Y-m-d H:i:s");
                                // $item->author_id = Yii::$app->user->identity->id;
                                $item->save(true);
                            } else { //new entry
                                $item->updated_at = date("Y-m-d h:i:s");
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
                    if ($valid_route) {
                        HimRoute::deleteAll(['him_id' => $model->id]);
                        foreach ($route_history as $index => $item) {
                            $item->created_at = date("Y-m-d H:i:s");
                            $item->author_id = Yii::$app->user->identity->id;
                            if ($item->him_id == null) { 
                                $item->him_id   = $model->id; 
                                $item->save(true);
                            } else { //new entry 
                                $item->save(false);
                            }
                        }
                    } else {
                        return print 'Error in saving';
                    }
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
                        'attachments' => $attachments,
                        'route_history'=>$route_history
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
            'attachments' => $attachments,
            'route_history'=>$route_history
        ]);
    }

    /**
     * Deletes an existing him model.
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
     * Finds the him model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return him the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = him::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
