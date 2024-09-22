<?php

use app\models\him;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\HimSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Hazard Information and Map';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="card shadow-lg">

        <div class="card-header">
            <div class="row">
                <div class="col-lg-9 col-sm-9">
                    <h3>Hazards Information and Map Requests</h3>
                </div>
                <div class="col-lg-3 col-sm-3 text-right"> <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?></div>
            </div>

        </div>

        <div class="card-body">

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout'       => "{summary}\n{items}\n<div class='ml-1'>{pager}</div>",
                'options'      => ['class' => 'table-responsive table-hover'],
                'pager'        => [

                    'class'                => '\yii\widgets\LinkPager',
                    'activePageCssClass'   => 'page-item active',
                    'linkOptions'          => ['class' => 'ml-1 mr-1 page-link'],
                    'disabledPageCssClass' => ' ml-1 mr-1page-item page-link disabled',

                ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],


                    [

                        'label'     => 'Reference',

                        'value'         => function ($model, $key, $index) {
                            return "HIM-" .  date_format(date_create($model->control_date), "M-y-") . str_pad($model->control_no, 3, "0", STR_PAD_LEFT);
                        },
                    ],
                    'staff_source:ntext',
                    'reference_gil:ntext',
                    'stakeholder:ntext',
                    'position:ntext',
                    'organization:ntext',
                    'purpose:ntext',
                    'information_requested:ntext',

                    'date_issued',
                    'date_released',
                    //'author_id',
                    //'created_at',
                    //'updated_at',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, him $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>

        </div>


    </div>
</div>
<br/>