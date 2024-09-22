<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\HimRoute $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="him-route-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'route_date')->textInput() ?>

    <?= $form->field($model, 'him_id')->textInput() ?>

    <?= $form->field($model, 'from_staff')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'to_staff')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'instructions')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'action_taken')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'author_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
