<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\scorecard $model */

$this->title = 'Create Scorecard';
$this->params['breadcrumbs'][] = ['label' => 'Scorecards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="scorecard-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
