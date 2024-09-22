<?php

use app\models\events;
use aryelds\sweetalert\SweetAlert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\EventsSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Events';
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
                    <h3>Events</h3>
                </div>
                <?php if (buttonVisibility() == true) { ?>
                    <div class="col-lg-3 col-sm-3 text-right"> <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?></div>

                <?php } ?>

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
                    'name:ntext',
                    'date_from',
                    'date_to',
                    'description:ntext',
                    [

                        'label'     => 'Status',
                        'format'        => 'html',
                        'value'         => function ($model, $key, $index) {
                            return $model->is_active == true ? '<span class="badge bg-success">Active</span> ' : '<span class="badge bg-warning">Disabled</span>'  . ($model->is_publish == true ? '<span class="badge bg-success">Published</span> ' : '');
                        },
                    ],
                    [
                        'class'          => ActionColumn::className(),
                        'contentOptions' => ['style' => 'width:8%; text-align:center;'],
                        'visibleButtons' => [
                            'visible' => (!Yii::$app->user->isGuest) ? true : false,
                            'delete'  => function ($model) {
                                return buttonVisibility();
                            },
                            'update'  => function () {
                                return buttonVisibility();
                            },
                            'view'  => function ($model) {
                                return true;
                            },
                        ],
                        'buttons'        => [
                            'delete' => function ($url, $model, $key) {
                                echo Html::beginForm('', 'post', ['id' => 'updates-form-grid']);
                                return Html::a('<i class="fa fa-trash"></i>', $url, [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'class' => 'delete-btn-updates-grid',
                                ]);
                                echo Html::endForm();
                            },
                        ],
                        'urlCreator'     => function ($action, events $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],

                ],
            ]); ?>


        </div>


    </div>
</div>
<br />

<?php
function buttonVisibility()
{
    if (Yii::$app->user->isGuest) {
        return false;
    }

    if (!Yii::$app->user->isGuest) {
        switch (Yii::$app->user->identity->user_type) {
            case 1:
                return true;
                break;
            case 2:
                return false;
                break;
            case 3:
                return false;
                break;
            case 4:
                return true;
                break;
            case 5:
                return false;
                break;
        }
    }
}
?>