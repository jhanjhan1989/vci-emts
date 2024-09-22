<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\HimSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="him-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'control_date') ?>

    <?= $form->field($model, 'control_no') ?>

    <?= $form->field($model, 'staff_source') ?>

    <?= $form->field($model, 'staff_responsible') ?>

    <?php // echo $form->field($model, 'reference_gil') ?>

    <?php // echo $form->field($model, 'stakeholder') ?>

    <?php // echo $form->field($model, 'position') ?>

    <?php // echo $form->field($model, 'organization') ?>

    <?php // echo $form->field($model, 'purpose') ?>

    <?php // echo $form->field($model, 'information_requested') ?>

    <?php // echo $form->field($model, 'no_of_disc') ?>

    <?php // echo $form->field($model, 'no_of_print') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'date_issued') ?>

    <?php // echo $form->field($model, 'date_released') ?>

    <?php // echo $form->field($model, 'author_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
