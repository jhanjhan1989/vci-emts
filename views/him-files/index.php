<?php

use app\models\HimFiles;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\HimFilesSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Hazard Information and Map';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <div class="card shadow-lg">

        <div class="card-header">
            <div class="row">
                <div class="col-lg-9 col-sm-9">
                    <h3>Hazards Information and Maps Attachments</h3>
                </div>
                <!-- <div class="col-lg-3 col-sm-3 text-right"> <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?></div> -->
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
                            return "HIM-" . date_format(date_create($model->has_Him()->control_date), "M-y-") . str_pad($model->has_Him()->control_no, 3, "0", STR_PAD_LEFT);
                        },
                    ],
                    'title:ntext',
                    'description:ntext',
                    [
                        'attribute'     => 'file_path', 
                        'format'        => 'html',
                        'label'         => 'Type',
                        'value'         => function ($data) {
                            if ($data['file_type'] == 'pptx') {
                            } else if ($data['file_type'] == 'pdf') {
                                return  '<i class="far text-danger fa-file-pdf fa-lg mr-2"></i> ' .$data['file_type'] ;
                            } else if ($data['file_type'] == 'docx' || $data['file_type'] == 'doc') {
                                return  '<i class="far text-primary fa-file-word fa-lg mr-2 "></i> ' .$data['file_type'] ;
                            } else if ($data['file_type'] == 'mp4' || $data['file_type'] == 'mpg' || $data['file_type'] == 'mpeg') {
                                return  '<i class="far fa-file-video fa-lg mr-2"></i> ' .$data['file_type'] ;
                            } else if ($data['file_type'] == 'xls' || $data['file_type'] == 'xlsx') {
                                return  '<i class="far text-success fa-file-excel fa-lg mr-2"></i> ' .$data['file_type'] ;
                            } else {
                                return "<i class='far text-info fa-file-image fa-lg mr-2'></i>  " .$data['file_type'] ;
                            }
                        }
                    ],
                    //'file_name',
                    //'file_type',
                    //'file_size',
                    //'file_path',
                    //'created_at',
                    //'updated_at',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, HimFiles $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>

        </div>


    </div>
</div>
<br />