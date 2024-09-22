<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\events $model */

$this->title = 'Update Events: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container">

    
    <?= $this->render('_form', [
          'model' => $model,
          'sports' => $sports,
          'teams'=>$teams
    ]) ?>

</div>
