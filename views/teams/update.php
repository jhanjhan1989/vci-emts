<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\teams $model */

$this->title = 'Update Teams: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Teams', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container"> 

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
