<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\eventteams $model */

$this->title = 'Create Eventteams';
$this->params['breadcrumbs'][] = ['label' => 'Eventteams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="eventteams-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
