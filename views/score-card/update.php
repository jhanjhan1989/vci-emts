<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\scorecard $model */

$this->title = 'Update Scorecard: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Scorecards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="scorecard-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
