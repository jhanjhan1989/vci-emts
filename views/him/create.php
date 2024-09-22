<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\him $model */

$this->title = 'New';
$this->params['breadcrumbs'][] = ['label' => 'Hazards Information and Map', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container"> 
    <?= $this->render('_form', [
        'model' => $model,
        'attachments'=>$attachments,
        'route_history'=>$route_history
    ]) ?>

</div>
