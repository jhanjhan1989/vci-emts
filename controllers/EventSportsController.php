<?php

namespace app\controllers;

use app\models\DashboardContestants;
use app\models\DashboardTabulate;
use app\models\Events;
use app\models\eventsports;
use app\models\EventSportsSearch;
use app\models\EventTeams;
use app\models\Model;
use app\models\ScoreCard;
use app\models\Sports;
use app\models\Teams;
use app\models\Venues;
use Exception;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * EventSportsController implements the CRUD actions for eventsports model.
 */
class EventSportsController extends Controller
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
     * Lists all eventsports models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EventSportsSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $venues      = Venues::find()->where(['is_deleted' => '0'])->orderBy('name')->all();
        $lVenues = ArrayHelper::map($venues, 'id', 'name');
        $events      = Events::find()->where(['is_deleted' => '0'])->orderBy('name')->all();
        $lEvents = ArrayHelper::map($events, 'id', 'name');

        $sports      = Sports::find()->where(['is_deleted' => '0'])->orderBy('name')->all();
        $lSports = ArrayHelper::map($sports, 'id', 'name');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'lVenues' => $lVenues,
            'lEvents' => $lEvents,
            'lSports' => $lSports,

        ]);
    }

    /**
     * Displays a single eventsports model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $teams = DashboardContestants::find()
            ->where([
                'event_id' => $model->event_id,
                'sport_id' => $model->sport_id
            ])
            ->orderBy([
                'score' => SORT_DESC,
            ])->all();
        return $this->render('view', [
            'model' => $model,
            'teams' => $teams
        ]);
    }

    /**
     * Creates a new eventsports model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new eventsports();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing eventsports model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $teams = EventTeams::find()->where(['event_id' => $model->event_id])->all();

        if ($model->load(Yii::$app->request->post())) {

            $teams = Model::createMultiple(EventTeams::classname());
            Model::loadMultiple($teams, Yii::$app->request->post());
            if (1 == 1) {

                $transaction = Yii::$app->db->beginTransaction();
                ScoreCard::deleteAll(['event_id' => $model->event_id, 'sport_id' => $model->sport_id]);
                try {
                    // return print_r($teams);
                    foreach ($teams as $item) {
                        $score_card_item = new ScoreCard([
                            'event_id' => $model->event_id,
                            'team_id' => $item->team_id,
                            'sport_id' => $model->sport_id,
                            'contestant_id' => 0,
                            'score' => $item->score,
                            'remarks' => $item->remarks,
                            'is_active' => 1,
                            'is_deleted' => 0,
                            'author_id' => Yii::$app->user->identity->id,
                            'created_at' =>  date("Y-m-d H:i:s"),
                        ]);

                        if (!($flag = $score_card_item->save(true))) {
                            $transaction->rollBack();
                            break;
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        Yii::$app->getSession()->setFlash('success', [
                            'text'              => 'Score card has been successfully updated.',
                            'title'             => 'Success!',
                            'type'              => 'success',
                            'timer'             => 3000,
                            'showConfirmButton' => false
                        ]);
                        return $this->redirect(['index']);
                    }
                } catch (Exception $e) {
                    return print_r($e);
                    $transaction->rollBack();
                    return $this->render('update', [
                        'model' => $model,
                        'teams' => $teams
                    ]);
                }
            }
        } else {
            $model->loadDefaultValues();
        }


        return $this->render('update', [
            'model' => $model,
            'teams' => $teams
        ]);
    }

    /**
     * Deletes an existing eventsports model.
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

    public function actionPublish( $id)
    {
        
        $score =  $this->findModel($id); 
        $score->is_publish=true;
        $score->updated_at =  date("Y-m-d H:i:s");
        $score->save(false);
        Yii::$app->getSession()->setFlash('success', [
            'text'              => 'Score card has been successfully updated.',
            'title'             => 'Success!',
            'type'              => 'success',
            'timer'             => 3000,
            'showConfirmButton' => false
        ]);
        return $this->redirect(['index']);
    }


    /**
     * Finds the eventsports model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return eventsports the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = eventsports::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
