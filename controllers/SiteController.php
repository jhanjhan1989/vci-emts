<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\DashboardTabulate;
use app\models\Events;
use app\models\EventSports;
use app\models\ScoreCard;
use app\models\Sports;
use app\models\Teams;
use Codeception\Lib\ParamsLoader;
use yii\helpers\ArrayHelper;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function getStats($id, $params)
    {
        $labels = [];
        $dataset = [];
        $data = [];
        if ($params > 0) {
            $sports = DashboardTabulate::find()->select(['sport_name', 'sport_id'])
                ->where(['event_id' => $id])
                ->where(['sport_id' => $params])
                ->groupBy('sport_id')
                ->orderBy('sport_name')
                ->all();
        } else {
            $sports = DashboardTabulate::find()->select(['sport_name', 'sport_id'])
                ->where(['event_id' => $id])
                ->groupBy('sport_id')
                ->orderBy('sport_name')
                ->all();
        }

        if ($params <= 0) {
            $teams = DashboardTabulate::find()->select(['team_name', 'team_id', 'department', 'sum(score) as total'])

                ->where(['event_id' => $id])
                ->groupBy('team_id')
                ->orderBy([
                    'total' => SORT_DESC,
                ])->all();


            foreach ($teams as $team) {
                $text = $team->team_name ?? '' . '  (' . $team->department ?? '' . ')';
                array_push($labels, $text);
            }
            foreach ($sports as $sport) {

                $row_data = [];
                foreach ($teams as $team) {
                    $score = DashboardTabulate::find()
                        ->where([
                            'event_id' => $id,
                            'team_id' => $team == null ? 0 : $team->team_id,
                            'sport_id' => $sport == null ? 0 : $sport->sport_id,
                        ])
                        ->one();

                    array_push($row_data, $score == null ? 0 : $score->score);
                }
                array_push($data, array(
                    'label' => $sport == null ? '' : $sport->sport_name ?? '',
                    'data' => $row_data,
                ));
            }
        } else {
            $teams = DashboardTabulate::find()->select(['team_name', 'team_id', 'department', 'sum(score) as total'])
                ->where([
                    'event_id' => $id,
                    'sport_id' => $params
                ])
                ->groupBy('team_id')
                ->orderBy([
                    'total' => SORT_DESC,
                ])->all();


            foreach ($teams as $team) {
                $text = $team->team_name ?? '' . '  (' . $team->department ?? '' . ')';
                array_push($labels, $text);
            }
            foreach ($sports as $sport) {

                $row_data = [];
                foreach ($teams as $team) {
                    $score = DashboardTabulate::find()
                        ->where([
                            'event_id' => $id,
                            'team_id' => $team == null ? 0 : $team->team_id,
                            'sport_id' => $params ,
                        ])
                        ->one();

                    array_push($row_data, $score == null ? 0 : $score->score);
                }
                array_push($data, array(
                    'label' => $sport == null ? '' : $sport->sport_name ?? '',
                    'data' => $row_data,
                ));
            }
        }



        array_push(
            $dataset,
            array('labels' => $labels),
            array('datasets' => $data)
        );

        return $dataset;
        // return dd($dataset);
    }


    public function getStatsPerformance($id)
    {
        $labels = [];
        $dataset = [];
        $data = [];
        $sports = DashboardTabulate::find()->select(['sport_name', 'sport_id'])->where(['event_id' => $id])->groupBy('sport_id')->orderBy('sport_name')->all();
        $teams = DashboardTabulate::find()->select(['team_name', 'team_id'])->where(['event_id' => $id])->groupBy('team_id')->all();
        foreach ($sports as $sport) array_push($labels, $sport->sport_name);
        foreach ($teams as $team) {

            $row_data = [];
            foreach ($sports as $sport) {
                $score = DashboardTabulate::find()
                    ->where([
                        'event_id' => $id,
                        'team_id' => $team->team_id,
                        'sport_id' => $sport->sport_id,
                    ])
                    ->one();

                array_push($row_data, $score == null ? 0 : $score->score);
            }
            array_push($data, array(
                'label' => $team->team_name,
                'data' => $row_data,
            ));
        }

        array_push(
            $dataset,
            array('labels' => $labels),
            array('datasets' => $data)
        );
        return $dataset;
    }

    public function actionTabulation($id, $sport_id)
    {
        if (Yii::$app->request->isAjax) {
            return $this->asJson($this->getStats($id, $sport_id ?? 0));
        }
    }
    public function actionUpdates($id)
    {
        $results = [];
        if (Yii::$app->request->isAjax) {
            $entries_created_at = ScoreCard::find()
                ->select('created_at')
                ->where(['event_id' => $id])
                ->groupBy('created_at')
                ->orderBy([
                    'created_at' => SORT_DESC,
                ])->all();
            foreach ($entries_created_at as $item) {
                $winner = ScoreCard::find()
                    ->where(['event_id' => $id])
                    ->where(['created_at' =>  $item->created_at])
                    ->orderBy([
                        'score' => SORT_DESC,
                    ])->one();
                if ($winner != null) {
                    $dept = Teams::findOne($winner->team_id);
                    $sport = Sports::findOne($winner->sport_id);
                    if ($dept != null && $sport != null) {
                        array_push($results, ($dept->name ?? '') .  ' wins ' .  ($sport->name ?? ''));
                    }
                }
            }
            return $this->asJson($results);
        }
    }

    public function actionPerformance($id)
    {
        if (Yii::$app->request->isAjax) {
            return $this->asJson($this->getStatsPerformance($id));
        }
    }

    public function actionEvents()
    {
        if (Yii::$app->request->isAjax) {
            return $this->asJson(Events::find()->where(['is_active' => 1, 'is_deleted' => 0])->orderBy(['date_from' => SORT_DESC])->all());
        }
    }

    public function actionSports($id)
    {
        if (Yii::$app->request->isAjax) {
            // $sports_in = EventSports::find()->select(['sport_id'])->where(['event_id' => $id])->column();
            // $sports = $this->asJson(Sports::find()->where(['is_deleted' => 0])->where(['in', 'id', $sports_in])->orderBy('name')->all());
            $sports = $this->asJson(Sports::find()->where(['is_deleted' => 0])->orderBy('name')->all());

            return $sports;
        }
    }
    public function actionIndex()
    {
        $tabulated = $this->getStats(1, 0);
        $tabulated_performance = $this->getStatsPerformance(1);
        $events = Events::find()->where(['is_deleted' => 0])->count();
        $sports = Sports::find()->where(['is_deleted' => 0])->count();
        $teams = Teams::find()->where(['is_deleted' => 0])->count();
        $events_list = Events::find()
            ->where(['is_active' => 1])
            // ->where( 'date_from', '>', date('Y-m-d'))
            ->orderBy('date_from')
            ->all();
        return $this->render('index', [
            'events' => $events,
            'sports' => $sports,
            'teams' => $teams,
            'tabulated' => $tabulated,
            'tabulated_performance' => $tabulated_performance,
            'events_list' => $events_list
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        $this->layout = false;
        return $this->render('main-login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
