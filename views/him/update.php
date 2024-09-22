<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\him $model */

$this->title = 'Update  ' .  "HIM-" .  date_format(date_create($model->control_date), "M-y-") . str_pad($model->control_no, 3, "0", STR_PAD_LEFT);
$this->params['breadcrumbs'][] = ['label' => 'Hazards Information and Map', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>  "HIM-" .  date_format(date_create($model->control_date), "M-y-") . str_pad($model->control_no, 3, "0", STR_PAD_LEFT), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container">

   
    <?= $this->render('_form', [
        'model' => $model,  
        'attachments'=>$attachments,
        'route_history'=>$route_history
    ]) ?>

</div>
