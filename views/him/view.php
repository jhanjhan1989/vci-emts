<?php

use app\models\HimFilesSearch;
use app\models\HimRouteSearch;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\him $model */

$this->title = "HIM-" . date("M-y-") . str_pad($model->control_no, 3, "0", STR_PAD_LEFT);
$this->params['breadcrumbs'][] = ['label' => 'Hazards Information and Map', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="container">
    <div class="card  shadow-lg">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-8 col-sm-8">
                    <h3><?= Html::encode($this->title) ?></h3>
                </div>
                <div class="col-lg-4 col-sm-4 text-right">

                    <p>
                        <?= Html::a('<i class="fas fa-edit  fa-lg"></i> Update  ', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a(' <i class="fas fa-trash  fa-lg"></i> Delete   ', ['delete'], [
                            "template" => "",
                            'type' => "button",
                            'class' => 'btn btn-danger ',

                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                </div>
            </div>

        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'control_no',
                        'value' => function ($model) {
                            return "OGL-" . date_format(date_create($model->control_date), "M-y-") . str_pad($model->control_no, 3, "0", STR_PAD_LEFT);
                        },
                    ],
                    'staff_source:ntext',
                    'staff_responsible:ntext',
                    'reference_gil',
                    'stakeholder:ntext',
                    'position:ntext',
                    'organization:ntext',
                    'purpose:ntext',
                    'information_requested:ntext',
                    'no_of_disc',
                    'no_of_print',
                    'status:ntext',
                    'date_issued',
                    'date_released',
                    'author_id',
                    'created_at',
                    'updated_at',
                ],
            ]) ?>

            <br />
            <?php
            $searchModel  = new HimFilesSearch();
            $dataProvider = $searchModel->searchByFile(Yii::$app->request->queryParams);
            $attachments  = $dataProvider->getTotalCount();
            if ($attachments) { ?>
                <h2>Attachments</h2>
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'options'      => ['class' => 'table-responsive table-hover  border-1 '],
                    'columns'      => [
                        'title',
                        'description',
                        [
                            'attribute'     => 'file_path',
                            'format'        => 'html',
                            'label'         => 'Type',
                            'value'         => function ($data) {
                                if ($data['file_type'] == 'pptx') {
                                } else if ($data['file_type'] == 'pdf') {
                                    return  '<i class="far text-danger fa-file-pdf fa-lg mr-2"></i> ' . $data['file_type'];
                                } else if ($data['file_type'] == 'docx' || $data['file_type'] == 'doc') {
                                    return  '<i class="far text-primary fa-file-word fa-lg mr-2 "></i> ' . $data['file_type'];
                                } else if ($data['file_type'] == 'mp4' || $data['file_type'] == 'mpg' || $data['file_type'] == 'mpeg') {
                                    return  '<i class="far fa-file-video fa-lg mr-2"></i> ' . $data['file_type'];
                                } else if ($data['file_type'] == 'xls' || $data['file_type'] == 'xlsx') {
                                    return  '<i class="far text-success fa-file-excel fa-lg mr-2"></i> ' . $data['file_type'];
                                } else {
                                    return "<i class='far text-info fa-file-image fa-lg mr-2'></i>  " . $data['file_type'];
                                }
                            }
                        ],
                        [
                            'class'          => 'yii\grid\ActionColumn',
                            'contentOptions' => ['style' => 'width:260px;'],
                            'header'         => 'Actions',
                            'visibleButtons' => [
                                'download' => function ($model) {
                                    return  $model->file_path != '' ?   true : false;
                                },

                            ],
                            'buttons'        => [

                                'download'  => function ($url, $model) {
                                    return Html::a('<span class="glyphicon glyphicon-download-alt"></span>', $url, [
                                        'title' => Yii::t('app', 'material-download'),

                                    ]);
                                },

                            ],


                            'template'       => (Yii::$app->user->isGuest) ? '{view} &nbsp; {download}' : '{view}&nbsp;{update}&nbsp;{download}&nbsp;{delete}',
                            'urlCreator'     => function ($action, $model, $key, $index) {
                                if ($action === 'view') {
                                    return  Url::toRoute(['him-files/view', 'id' => $model->id]);
                                }
                                if ($action === 'update') {
                                    return  Url::toRoute(['him-files/update', 'id' => $model->id]);
                                }
                                if ($action === 'delete') {
                                    return  Url::toRoute(['him-files/delete', 'id' => $model->id]);
                                }
                                if ($action === 'download') {
                                    return  Url::toRoute(['him-files/download', 'id' => $model->id]);
                                }
                            },
                        ],
                    ],
                ]);
            } else { ?>
                <h3>No Attachments</h3>
            <?php }
            ?>
            <br />
            <?php
            $searchModel_route  = new HimRouteSearch();
            $dataProvider_route = $searchModel_route->search(['him_id'=>$model->id]);
            $route_history  = $dataProvider_route->getTotalCount();
            if ($route_history) { ?>
                <h2>Route History</h2>
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider_route,
                    'options'      => ['class' => 'table-responsive table-hover  border-1 '],
                    'columns'      => [
                        'route_date',
                        'from_staff', 
                        'to_staff', 
                        'instructions', 
                        [
                            'class'          => 'yii\grid\ActionColumn',
                            'contentOptions' => ['style' => 'width:260px;'],
                            'header'         => 'Actions',
                            'template'       => (Yii::$app->user->isGuest) ? '{view} &nbsp; {download}' : '{view}&nbsp;{update}&nbsp;{download}&nbsp;{delete}',
                            'urlCreator'     => function ($action, $model, $key, $index) {
                                if ($action === 'view') {
                                    return  Url::toRoute(['him-route/view', 'id' => $model->id]);
                                }
                                if ($action === 'update') {
                                    return  Url::toRoute(['him-route/update', 'id' => $model->id]);
                                }
                                if ($action === 'delete') {
                                    return  Url::toRoute(['him-route/delete', 'id' => $model->id]);
                                }
                                if ($action === 'download') {
                                    return  Url::toRoute(['him-route/download', 'id' => $model->id]);
                                }
                            },
                        ],
                    ],
                ]);
            } else { ?>
                <h3>No Routing History</h3>
            <?php }
            ?>

        </div>
    </div>







</div>
<br />