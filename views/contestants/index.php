<?php

use app\controllers\VenuesController;
use app\models\Contestants;
use app\models\Events;
use app\models\eventsports;
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

$this->title = 'Players / Contestants';
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
                            $result = Events::findOne(['id' => $data['event_id']]);
                            return $result!=null ? $result->name:'Not set';
                            
                        }
                    ],
                    [
                        'attribute' => 'sport_id',
                        'format'        => 'html',
                        'filter'    => $lSports,
                        'value'         => function ($data) {
                            
                            $result =  Sports::findOne(['id' => $data['sport_id']]);
                            return $result!=null ? $result->name:'Not set';
                        }
                    ],
                    [
                        'attribute' => 'venue_id',
                        'format'        => 'html',
                        'filter'    => $lVenues,
                        'value'         => function ($data) {
                            $result = Venues::findOne(['id' => $data['venue_id']]);
                            return $result!=null ? $result->name:'Not set';
                           
                        }
                    ],
                    [
                        'label' => 'Players',
                        'format'        => 'html',  
                        'options' => ['class' => 'text-center'],
                        'value'         => function ($data) {
                            $contestants=Contestants::find()->where([
                                'event_id' => $data['event_id'],
                                'sport_id' => $data['sport_id']
                            ])->count();
                            return '<center>' .  $contestants . '</center>';
                        }
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