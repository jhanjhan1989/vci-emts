<?php

use app\models\sports;
use aryelds\sweetalert\SweetAlert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SportsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Sports / Competitions';
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
                    <h3>Sports / Competitions</h3>
                </div>
                <div class="col-lg-3 col-sm-3 text-right"> <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?></div>
            </div>

        </div>

        <div class="card-body">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'pager'        => [
                    'class'                => '\yii\bootstrap4\LinkPager', 
                ],
                'options'=> [
                    'class'=>'table-hover '
                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'], 
                    'name:ntext',
                    'description:ntext',
                    [

                        'label'     => 'Status', 
                        'format'        => 'html',
                        'value'         => function ($model, $key, $index) {
                             return $model->is_active==true? '<span class="badge bg-success">Active</span> ':'<span class="badge bg-danger">Disabled</span>';
                        },
                    ],
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, sports $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>


        </div>


    </div>
</div>
<br />
 