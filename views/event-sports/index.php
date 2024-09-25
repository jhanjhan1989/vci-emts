<?php

use app\controllers\VenuesController;
use app\models\Events;
use app\models\eventsports;
use app\models\ScoreCard;
use app\models\Sports;
use app\models\Venues;
use aryelds\sweetalert\SweetAlert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\EventSportsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Score Cards';
$this->params['breadcrumbs'][] = $this->title;
foreach (Yii::$app->session->getAllFlashes() as $message) {
    echo SweetAlert::widget([
        'options' => [
            'title'             => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
            'text'              => (!empty($message['text'])) ? Html::encode($message['text']) : 'Text Not Set!',
            'type'              => (!empty($message['type'])) ? $message['type'] : SweetAlert::TYPE_INFO,
            'timer'             => (!empty($message['timer'])) ? $message['timer'] : 4000,
            'showConfirmButton' => (!empty($message['showConfirmButton'])) ? $message['showConfirmButton'] : true
        ]
    ]);
}
?> 


<div class="container">
    <div class="card shadow-lg">

        <div class="card-header">
            <div class="row">
                <div class="col-lg-9 col-sm-9">
                    <h3><?php echo $this->title ?></h3>
                </div>
                <!-- <div class="col-lg-3 col-sm-3 text-right"> <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?></div> -->
            </div>

        </div>

        <div class="card-body">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'options' => [
                    'class' => 'table-hover '
                ],
                'pager'        => [
                    'class'                => '\yii\bootstrap4\LinkPager', 
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'], 
                    [
                        'attribute' => 'event_id',
                        'format'        => 'html',
                        'filter'    => $lEvents,
                        'value'         => function ($data) {
                            return Events::findOne(['id' => $data['event_id']])->name;
                        }
                    ],
                    [
                        'attribute' => 'sport_id',
                        'format'        => 'html',
                        'filter'    => $lSports,
                        'value'         => function ($data) {
                            $sport = Sports::findOne(['id' => $data['sport_id']]);
                            return $sport!=null ? $sport->name:'Not set';
                        }
                    ],
                    [
                        'attribute' => 'venue_id',
                        'format'        => 'html',
                        'filter'    => $lVenues,
                        'value'         => function ($data) {
                            $result =Venues::findOne(['id' => $data['venue_id']]);
                            return $result!=null ? $result->name:'Not set';
                            
                        }
                    ],
                    [
                        'label' => 'Teams (w/ Score)',
                        'format'        => 'html',  
                        'options' => ['class' => 'text-center'],
                        'value'         => function ($data) {
                            $score=ScoreCard::find()->where([
                                'event_id' => $data['event_id'],
                                'sport_id' => $data['sport_id']
                            ])->count();
                            return '<center>' .  $score . '</center>';
                        }
                    ],
                    [

                        'label'     => 'Published', 
                        'format'        => 'html',
                        'value'         => function ($model, $key, $index) {
                             return $model->is_publish==true? '<center><span class="badge bg-success">Yes</span> </center>':'<center><span class="badge bg-danger">No</span></center>';
                        },
                    ],

                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => [],
                        'header' => 'Actions',
                        'template' => '{view} {update}  ',

                    ],
                ],
            ]); ?>


        </div>


    </div>
</div>
<br />