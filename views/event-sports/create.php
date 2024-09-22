<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\eventsports $model */

$this->title = 'Create Eventsports';
$this->params['breadcrumbs'][] = ['label' => 'Eventsports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eventsports-create">

    

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
