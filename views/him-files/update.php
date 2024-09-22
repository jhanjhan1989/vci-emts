<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\himfiles $model */

$this->title = 'Update Himfiles: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'HIM Attachments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="himfiles-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
