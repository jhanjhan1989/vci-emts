<?php

use app\models\Agency;
use yii\helpers\Html;
use yii\widgets\DetailView;
use aryelds\sweetalert\SweetAlert;

/* @var $this yii\web\View */
/* @var $model app\models\Member */

$this->title                   = $model->firstname . ' ' . $model->lastname;
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

foreach (Yii::$app->session->getAllFlashes() as $message) {
    echo SweetAlert::widget([
        'options' => [
            'title'             => (!empty ($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
            'text'              => (!empty ($message['text'])) ? Html::encode($message['text']) : 'Text Not Set!',
            'type'              => (!empty ($message['type'])) ? $message['type'] : SweetAlert::TYPE_INFO,
            'timer'             => (!empty ($message['timer'])) ? $message['timer'] : 4000,
            'showConfirmButton' => (!empty ($message['showConfirmButton'])) ? $message['showConfirmButton'] : true
        ]
    ]);
}
?>
<div class="member-view">
    <div class="container">

        <h1>
            <?= Html::encode($this->title) ?>
        </h1>
        <p>
            <?php
            if (!Yii::$app->user->isGuest && Yii::$app->user->identity->user_type == 1) {
                echo Html::beginForm('', 'post', ['id' => 'member-form']);

                echo Html::a('Update', ['update', 'id' => $model->member_id], ['class' => 'btn btn-primary mr-2 btn-sm']);

                // original code, to display the default alert box
                // echo Html::a('Delete', ['delete', 'id' => $model->member_id], [
                //     'class' => 'btn btn-danger btn-sm',
                //     'data' => [
                //         'confirm' => 'Are you sure you want to delete this item?',
                //         'method' => 'post',
                //     ],
                // ]) ;
            
                echo Html::a('Delete', ['delete', 'id' => $model->member_id], [
                    'class'   => 'btn btn-danger btn-sm delete-btn-member',
                    'onclick' => 'return false;',
                ]);

                echo Html::endForm();
            } ?>
        </p>

        <div class="col-lg-8">

            <?= DetailView::widget([
                'model'      => $model,
                'attributes' => [
                    // 'member_id',
                    // 'value' => 'backendUser.sector_id', // Display the related data
                    // [                      // the owner name of the model
                    //     'label' => 'Username',
                    //     'value' => function($model){
                    //         return $model->backendUser->username;
                    //     },
                    // ],
                    'firstname',
                    'lastname',
                    [                      // the owner name of the model
                        'label' => 'Status',
                        'value' => function ($model) {
                            if ($model->status == '1') {
                                return "Active";
                            } else {
                                return "Inactive";
                            }
                        },
                    ],
                    [
                        'label' => 'Sector',
                        'value' => function ($model) {
                            if ($model->backendUser->sector_id == '1') {
                                return "Water";
                            } else if ($model->backendUser->sector_id == '2') {
                                return "Food";
                            } else if ($model->backendUser->sector_id == '3') {
                                return "Health";
                            } else if ($model->backendUser->sector_id == '4') {
                                return "Energy";
                            } else if ($model->backendUser->sector_id == '5') {
                                return "Safety";
                            } else {
                                return "--";
                            }
                        },
                    ],
                    
                    'date_updated',
                ],
            ]) ?>
            <table>
                <tr>
                    <?php
                    if (Yii::$app->user->isGuest) {
                        // echo Html::beginForm(['payment/create-new','id'=>$model->member_id], 'post' );  
                        //   echo  Html::submitButton('Proceed to Payment', ['class' => 'btn btn-primary mb-5','target'=>'_blank']);  
                    } ?>
                </tr>
            </table>
        </div>
    </div>
</div>



<?php
// JavaScript to handle delete action with SweetAlert
$js = <<<JS
        $(document).ready(function() {
            $('.delete-btn-member').click(function(e) {
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