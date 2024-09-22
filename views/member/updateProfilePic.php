<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Member */
/* @var $modelUser app\models\BackendUser */

$this->title = 'Update Profile Picture ';
$this->params['breadcrumbs'][] = ['label' => 'Members', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->member_id, 'url' => ['view', 'id' => $model->member_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="member-update">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>When uploading images for your profile, kindly use images with <b>same width and height</b> for optimum rendering. </p><br>
    <?= $this->render('_formProfilePicture', [
        'model' => $model, 
    ]) ?>

</div>
