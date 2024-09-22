<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\HimRouteSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="him-route-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'route_date') ?>

    <?= $form->field($model, 'him_id') ?>

    <?= $form->field($model, 'from_staff') ?>

    <?= $form->field($model, 'to_staff') ?>

    <?php // echo $form->field($model, 'instructions') ?>

    <?php // echo $form->field($model, 'action_taken') ?>

    <?php // echo $form->field($model, 'due_date') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'author_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
