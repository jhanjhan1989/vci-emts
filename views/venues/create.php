<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\venues $model */

$this->title = 'New Entry';
$this->params['breadcrumbs'][] = ['label' => 'Venues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container"> 
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
