<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\eventsports $model */

$this->title = 'Update Score Card : ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Score Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="eventsports-update">

    
    <?= $this->render('_form', [
        'model' => $model,
        'teams' => $teams,
    ]) ?>

</div>
