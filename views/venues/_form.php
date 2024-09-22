<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\venues $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="container">

    <?php $form = ActiveForm::begin(); ?>


    <div class="card  shadow-lg mb-5">
        <div class="card-header h3">
            <div class="row">
                <div class="col-lg-9 col-sm-9">
                    <?php
                    echo $model->id ? 'Update  ' .   $model->name  : "New Entry"  ?>

                </div>
                <div class="col-lg-3 col-sm-3 text-right">
                    <?= Html::a('<i class="fas fa-times  fa-lg"></i>', ['index'], ["template" => "", 'type' => "button", 'class' => 'btn btn-tool', "data-widget" => "remove"]) ?>

                </div>
            </div>

        </div>
        <div class="card-body">
            <?= $form->field($model, 'name')->textInput() ?>

            <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?> 
 
        </div>

        <div class="card-footer">
            <div class="form-group float-right">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

    </div>
    <?php ActiveForm::end(); ?>


</div>