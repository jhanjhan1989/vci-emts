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

<div class="member-form">
    <?php $form = ActiveForm::begin(['id' => 'registration-form']); ?>
    <div class="row">
        <div class="col-lg-8">

            <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'email')->input('email') ?>

            <?= $form->field($modelUser, 'user_type')->dropDownList([
                '1' => 'Super Admin',
                '2' => 'Publisher',
                '3' => 'Master Tabulator',
                '4' => 'Event Manager',
                '5' => 'Content Manager'
            ], ['prompt' => 'Select...']); ?>
        </div>
        <div class="col-lg-4">
            <?= $form->field($modelUser, 'username')->textInput(['maxlength' => true, 'placeholder' => ""])->label('User Name') ?>

            <?php echo $form->field($modelUser, 'password')->passwordInput(['placeholder' => Yii::t('app', 'unchanged'), 'value' => '']);
            echo $form->field($modelUser, 'password_confirm')->passwordInput(['placeholder' => Yii::t('app', 'unchanged'), 'value' => '']);
            echo $form->field($model, 'status')->dropDownList(
                [
                    '1' => 'Active',
                    '0' => 'Inactive',
                ],
                ['prompt' => 'Select...']
            );
            ?>

        </div>
    </div>

    <div class="form-group" style="padding-top:10px;">
        <?= Html::submitButton('<i class="fa fa-save"></i>  Save', ['class' => 'btn btn-success btn-sm', 'id' => 'btnsubmit-registration']) ?>
        <?php echo \yii\helpers\Html::a('Cancel', Yii::$app->request->referrer, ['class' => 'btn btn-danger btn-sm']); ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$script = <<<JS
    $(document).ready(function () {
        //for item payment
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