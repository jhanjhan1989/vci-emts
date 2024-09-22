<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\eventteams $model */

$this->title = 'Update Eventteams: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Eventteams', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="eventteams-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
