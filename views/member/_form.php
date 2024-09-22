<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\password\PasswordInput;
use app\models\Agency;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $model app\models\Member */
/* @var $modelUser app\models\BackendUser */
/* @var $form yii\widgets\ActiveForm */



?>
<div class="container">

    <?php $form = ActiveForm::begin(['id' => 'registration-form']); ?>


    <div class="card  shadow-lg mb-5">
        <div class="card-header h3">
            <div class="row">
                <div class="col-lg-9 col-sm-9">
                    <?php
                    echo $model->firstname ? 'Update  ' .  $model->firstname : "New Entry"  ?>

                </div>
                <div class="col-lg-3 col-sm-3 text-right">
                    <?= Html::a('<i class="fas fa-times  fa-lg"></i>', ['index'], ["template" => "", 'type' => "button", 'class' => 'btn btn-tool', "data-widget" => "remove"]) ?>

                </div>
            </div>

        </div>
        <div class="card-body">


            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($model, 'email')->input('email') ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($modelUser, 'user_type')->dropDownList([
                                '1' => 'Super Admin',
                                '2' => 'Publisher',
                                '3' => 'Master Tabulator',
                                '4' => 'Event Manager',
                                '5' => 'Content Manager'
                            ], ['prompt' => 'Select...']); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-muted small">
                            <span class="mb-2  ">List of user types and their role/s </span>
                            <table class="pl-0 pt-2 table-responsive   table-borderless table">
                                <thead>
                                    <tr>
                                        <td class="pl-0 pt-0 pb-0 text-muted  font-weight-bold">Type</td>
                                        <td class="pt-0 pb-0 text-muted font-weight-bold  ">Role/s</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="pl-0 pt-0 pb-0 text-muted  ">Super Admin</td>
                                        <td class="pt-0 pb-0 text-muted  ">Full Access</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-0 pt-0 pb-0 text-muted  ">Publisher</td>
                                        <td class="pt-0 pb-0 text-muted  ">Publishing of results/score</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-0 pt-0 pb-0 text-muted  ">Master Tabulator</td>
                                        <td class="pt-0 pb-0 text-muted  ">Responsible for Scores data entry</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-0 pt-0 pb-0 text-muted  "> Event Manager</td>
                                        <td class="pt-0 pb-0 text-muted  ">Management of events, its participating teams and constestant/player per team</td>
                                    </tr>
                                    <tr>
                                        <td class="pl-0 pt-0 pb-0 text-muted  ">Content Manager</td>
                                        <td class="pt-0 pb-0 text-muted  ">Manages libraries such as list of sports, venues and teams/ departments</td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                    </div>






                </div>
                <div class="col-lg-4">
                    <?= $form->field($modelUser, 'username')->textInput(['maxlength' => true, 'placeholder' => ""])->label('User Name')  ?>

                    <?php echo $form->field($modelUser, 'password')->passwordInput(['placeholder' => Yii::t('app', 'unchanged'), 'value' => '']);

                    echo  $form->field($modelUser, 'password_confirm')->passwordInput(['placeholder' => Yii::t('app', 'unchanged'), 'value' => '']) ?>
                </div>
            </div>


        </div>

        <div class="card-footer">
            <div class=" float-right">
                <?= Html::submitButton('<i class="fa fa-save"></i>  Save', ['class' => 'btn btn-success  ', 'id' => 'btnsubmit-registration']) ?>
                <?php echo \yii\helpers\Html::a('<i class="fa fa-close"></i>   Cancel', Yii::$app->request->referrer, ['class' => 'btn btn-danger ']); ?>

            </div>
        </div>

    </div>
    <?php ActiveForm::end(); ?>


</div>

<?php
$script = <<< JS
    // $(document).ready(function () {
    //     //for item payment
    //     var item = $('#backenduser-user_type').val();
    //     if(item){
    //         $("#purpose").val(3);
    //         $("#item_id").val(item);
    //     }
    // });

$(document.body).on('change', '#backenduser-user_type', function () {
    $("#backenduser-sector_id").val("");
    $("#backenduser-agency_id").val("");
    var val = $('#backenduser-user_type').val();
      if(val ==1 || val ==4 ) {
        console.log('not required');
        $('#backenduser-sector_id').prop('disabled', true);
        $('#backenduser-agency_id').prop('disabled', true);
        $('#backenduser-sector_id').removeAttr("aria-required");
        $('#backenduser-sector_id').removeAttr("required");
      }else{
        console.log('required');
        $('#backenduser-sector_id').prop('disabled', false);
        $('#backenduser-agency_id').prop('disabled', false);
        $('#backenduser-sector_id').attr("aria-required", "true"); 
        $('#backenduser-sector_id').attr("required", "true"); 
      }
    });
JS;
$this->registerJs($script);
?>