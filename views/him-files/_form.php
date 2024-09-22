<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\OglFiles $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="container">

    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
        ]
    ]);
    ?>
    <div class="card shadow-lg">
        <div class="card-header h3">
            <div class="row">
                <div class="col-lg-9 col-sm-9">
                    <?php echo $model->id ? 'Update  ' .  $model->title : "New Entry"  ?>
                </div>
                <div class="col-lg-3 col-sm-3 text-right">
                    <?= Html::a('<i class="fas fa-times  fa-lg"></i>', ['index'], ["template" => "", 'type' => "button", 'class' => 'btn btn-tool', "data-widget" => "remove"]) ?>
                </div>
            </div>

        </div>
        <div class="card-body">
            <?= $form->field($model, 'title')->textInput() ?>
            <?= $form->field($model, 'description')->textInput() ?>

            <?php

            if ($model->file_type == 'png' || $model->file_type == 'jpg' || $model->file_type == 'gif' || $model->file_type == 'svg' || $model->file_type == 'jpeg') {
            ?>
                <div class="" style="width:100%">
                    <?php echo  Html::img($model->file_path, ['class' => 'img-fluid']) ?>
                </div>
            <?php
            } ?>

            <?= $form->field($model, "imageFile")->fileInput()->label(false); ?>
        </div>
        <div class="card-footer">
            <div class="form-group">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

    </div>
    <?php ActiveForm::end(); ?>

</div>
<br>