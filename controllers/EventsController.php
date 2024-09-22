<?php

namespace app\controllers;

use app\models\events;
use app\models\EventSports;
use app\models\EventsSearch;
use app\models\EventTeams;
use app\models\HimFiles;
use app\models\Model;
use app\models\Sports;
use app\models\Teams;
use Exception;
use GuzzleHttp\Psr7\Query;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventsController implements the CRUD actions for events model.
 */
class EventsController extends Controller
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
     * Lists all events models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EventsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single events model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $sports = EventSports::find()->where(['event_id' => $id, 'is_deleted'=>0])->all();
        $teams = EventTeams::find()->where(['event_id' => $id, 'is_deleted'=>0])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'sports'=>$sports,
            'teams'=>$teams
        ]);
    }

    public function actionSports()
    {
         
        $search_reference = Yii::$app->request->post('search_reference');
        $rows=EventSports::find()->where(['event_id'=>$search_reference, 'is_deleted'=>0])->all();
        
        $data = [];
        if(!empty($rows)) {
            foreach($rows as $row) {
                $sport = Sports::findOne($row['sport_id']);
                $data[] = ['id' => $sport['id'], 'name' =>  $sport['name']];
            }
        } else {
            $data = '';
        }

        return $this->asJson($data);

    }


    /**
     * Creates a new events model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $sports = [new EventSports([
            "author_id" => Yii::$app->user->identity->id,
            "created_at" => date("Y-m-d H:i:s"),
            "is_active" => "true",
            "is_deleted" => "0",
            "event_id" => "0",
            "id" => "0"
        ])];
        $model = new events([
            "author_id" => Yii::$app->user->identity->id,
            "created_at" => date("Y-m-d H:i:s"),
            "is_active" => 1,
            "is_deleted" => 0,
            "is_publish"=>0
        ]);
        $teams = [new EventTeams([
            "author_id" => Yii::$app->user->identity->id,
            "created_at" => date("Y-m-d H:i:s"),
            "is_active" => 1,
            "is_deleted" => 0,
            "event_id" => 0
        ])];

        if ($model->load(Yii::$app->request->post())) {

            $sports = Model::createMultiple(EventSports::classname());
            Model::loadMultiple($sports, Yii::$app->request->post());
            $valid = Model::validateMultiple($sports);

            $teams = Model::createMultiple(EventTeams::classname());
            Model::loadMultiple($teams, Yii::$app->request->post());
            $valid2 = Model::validateMultiple($teams);
            $model->author_id = Yii::$app->user->identity->id; 
            $model->created_at = date("Y-m-d H:i:s");
            // return print_r($model);
            if ($model->validate() && $model->save()) {
                if ($valid && $valid2) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {

                        foreach ($sports as $item) {

                            $item->author_id = Yii::$app->user->identity->id;
                            $item->event_id = $model->id;
                            $item->created_at = date("Y-m-d H:i:s");
                            if (!($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        foreach ($teams as $item) {
                            $item->author_id = Yii::$app->user->identity->id;
                            $item->event_id = $model->id;
                            $item->created_at = date("Y-m-d H:i:s");

                            if (!($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        if ($flag) {
                            $transaction->commit();
                            Yii::$app->getSession()->setFlash('success', [
                                'text'              => 'Event information is successfully saved.',
                                'title'             => 'Success!',
                                'type'              => 'success',
                                'timer'             => 3000,
                                'showConfirmButton' => false
                            ]);

                            return $this->redirect(['index']);
                        }
                    } catch (Exception $e) {

                        $transaction->rollBack();
                        return $this->render('create', [
                            'model' => $model,
                            'sports' => $sports,
                            'teams' => $teams
                        ]);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'sports' => $sports,
            'teams' => $teams
        ]);
    }

    /**
     * Updates an existing events model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->updated_at = date("Y-m-d H:i:s");
        $sports = EventSports::find()->where(['event_id' => $model->id, 'is_deleted'=>0])->all();
        $teams = EventTeams::find()->where(['event_id' => $model->id, 'is_deleted'=>0])->all();
        if (!$sports) {
            $sports = [new EventSports()];
        }
        if (!$teams) {
            $teams = [new EventTeams()];
        }

        if ($model->load(Yii::$app->request->post())) {

            $sports = Model::createMultiple(EventSports::classname());
            Model::loadMultiple($sports, Yii::$app->request->post());
            $valid = Model::validateMultiple($sports);

            $teams = Model::createMultiple(EventTeams::classname());
            Model::loadMultiple($teams, Yii::$app->request->post());
            $valid2 = Model::validateMultiple($teams);
            if ($model->validate() && $model->save()) {
                if ($valid && $valid2) {
                    $transaction = Yii::$app->db->beginTransaction();
                    EventSports::deleteAll(['event_id' => $model->id]);
                    EventTeams::deleteAll(['event_id' => $model->id]);
                    try {

                        foreach ($sports as $item) {

                            $item->author_id = Yii::$app->user->identity->id;
                            $item->event_id = $model->id;
                            $item->created_at = date("Y-m-d H:i:s");
                            if (!($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }


                        foreach ($teams as $item) {
                            $item->author_id = Yii::$app->user->identity->id;
                            $item->event_id = $model->id;
                            $item->created_at = date("Y-m-d H:i:s");
                            if (!($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        if ($flag) {
                            $transaction->commit();
                            Yii::$app->getSession()->setFlash('success', [
                                'text'              => 'Event information is successfully saved.',
                                'title'             => 'Success!',
                                'type'              => 'success',
                                'timer'             => 3000,
                                'showConfirmButton' => false
                            ]);
                            return $this->redirect(['index']);
                        }
                    } catch (Exception $e) {

                        $transaction->rollBack();
                        return $this->render('update', [
                            'model' => $model,
                            'sports' => $sports,
                            'teams' => $teams
                        ]);
                    }
                }
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('update', [
            'model' => $model,
            'sports' => $sports,
            'teams' => $teams
        ]);
    }

    /**
     * Deletes an existing events model.
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
     * Finds the events model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return events the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = events::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
