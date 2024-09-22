<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Member */
/* @var $modelUser app\models\BackendUser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="member-form">

    <?php $form = ActiveForm::begin([ 'options' => ['enctype' => 'multipart/form-data'],]); ?>
    <div class="row">
        <div class="col-lg-5">
            <?= $form->field($model, 'imageFile')->fileInput() ?>
        </div>
    </div>
    <hr style="border-top: 1px dotted #3c8dbc;">
    
    <div class="form-group">
        <?= Html::submitButton('<i class="fa fa-save"></i>  Save', ['class' => 'btn btn-success btn-sm']) ?>
        <?php echo \yii\helpers\Html::a( 'Back', Yii::$app->request->referrer,['class' => 'btn btn-primary']); ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>
