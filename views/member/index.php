<?php

use app\models\Agency;
use app\models\Sector;
use yii\helpers\Html;
use yii\grid\GridView;
use aryelds\sweetalert\SweetAlert;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MemberSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title                   = 'Users';
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
                    <h3>User Accounts</h3>
                </div>
                <div class="col-lg-3 col-sm-3">
                    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->user_type == 1) { ?>
                        <p>
                            <?php //echo Html::a('<i class="fa fa-plus"></i>  Create New Account', ['create'], ['class' => 'btn btn-success btn-sm']) ;      
                            ?>
                        </p>
                    <?php
                    } ?>

                    <?= Html::beginForm(['member/create'], 'post'); ?>
                    <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->user_type == 1 || !Yii::$app->user->isGuest && Yii::$app->user->identity->user_type == 2) { ?>
                        <?= Html::submitButton('<i class="fa fa-plus"></i>  Create Account', ['class' => 'btn btn-success  float-right']); ?>
                    <?php
                    } ?>


                    <?= Html::endForm(); ?>
                </div>
            </div>

        </div>

        <div class="card-body">

            <?= GridView::widget([
                'id'           => 'memlist',
                'dataProvider' => $dataProvider,
                'filterModel'  => $searchModel,
                'layout'       => "{summary}\n{items}\n<div class='ml-1'>{pager}</div>",
                'options'      => ['class' => 'table-responsive border-1'],
                'pager'        => [
                    'class'                => '\yii\bootstrap4\LinkPager',
                ],
                'rowOptions'   => function ($model) {
                    if ($model->status == 4)
                        return ['style' => 'color: #a7a0a0 ; '];
                },
                'columns'      => [
                    // ['class' => 'yii\grid\CheckboxColumn'],
                    [
                        'attribute' => 'lastname',
                        'value'     => function ($model) {
                            return ucwords($model->lastname);
                        },
                    ],

                    [
                        'attribute' => 'firstname',
                        'value'     => function ($model) {
                            return ucwords($model->firstname);
                        },
                    ],
                    [
                        'attribute' => 'membership_type',
                        'filter'    => ['1' => 'Super Admin', '2' => 'Publisher', '3' => 'Master Tabulator', '4' => 'Event Manager', '5' => 'Content Manager'],
                        'format'    => 'raw',
                        'value'     => function ($model, $key, $index) {
                            if ($model->membership_type == '1') {
                                return "Super Admin";
                            } else if ($model->membership_type == '2') {
                                return "Publisher";
                            } else if ($model->membership_type == '3') {
                                return "Master Tabulator";
                            } else if ($model->membership_type == '4') {
                                return "Event Manager";
                            } else if ($model->membership_type == '5') {
                                return "Content Manager";
                            }
                        },
                    ],

                    [
                        'attribute' => 'status',
                        'filter'    => [
                            '1' => 'Active',
                            '0' => 'Inactive',
                        ],
                        'format'    => 'raw',
                        'value'         => function ($model, $key, $index) {
                            return $model->status == true ? '<span class="badge bg-success">Active</span> ' : '<span class="badge bg-danger">Disabled</span>';
                        },
                        //                    'visible'=>(!Yii::$app->user->isGuest)? 1: 0
                    ],
                    [
                        'class'          => 'yii\grid\ActionColumn',
                        'contentOptions' => ['style' => 'width:8%; text-align:center;'],
                        'header'         => 'Actions',
                        'template'       =>  '{view}{update}{delete}',
                        'buttons'        => [
                            'delete' => function ($url, $model, $key) {
                                echo Html::beginForm('', 'post', ['id' => 'member-form-grid']);
                                return Html::a('<i class="fa fa-trash"></i>', $url, [
                                    'title' => Yii::t('yii', 'Delete'),
                                    'class' => 'delete-btn-member-grid',
                                ]);
                                echo Html::endForm();
                            },
                        ],
                        // 'urlCreator'     => function ($action, $model, $key, $index) {
                        //     if ($action === 'view') {
                        //         $url = 'view?id=' . $model->member_id;
                        //         return $url;
                        //     }
                        //     if ($action === 'update') {
                        //         $url = 'update?id=' . $model->member_id;
                        //         return $url;
                        //     }
                        //     if ($action === 'delete') {
                        //         $url = 'delete?id=' . $model->member_id;
                        //         return $url;
                        //     }
                        // }
                    ],
                ],
            ]); ?>


        </div>


    </div>
</div>
<br />

<?php
// JavaScript to handle delete action with SweetAlert
$js = <<<JS
        $(document).ready(function() {
            $('.delete-btn-member-grid').click(function(e) {
                e.preventDefault();
                var form = $(this).closest('form');
                var url = $(this).attr('href'); 
                swalDelete('Delete?', 'Are you sure you want to delete this item?', 'warning', '', true, url, form);
            });
        });
    JS;
$this->registerJs($js);
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="<?php echo Yii::$app->urlManager->baseUrl . "/js/sweetalert-custom-delete.js"; ?>"></script>