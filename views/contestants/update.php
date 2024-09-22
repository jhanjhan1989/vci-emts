<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\eventsports $model */

$this->title = 'Update Contestant / Player : ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Players / Contestants', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="eventsports-update">

    
    <?= $this->render('_form', [
        'model' => $model,
        'teams' => $teams,
    ]) ?>

</div>
