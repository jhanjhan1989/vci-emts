<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\venues $model */

$this->title = 'Update Venues: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Venues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container"> 

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
