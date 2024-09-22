<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\sports $model */

$this->title = 'Update Sports: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container">
 
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
