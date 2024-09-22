<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\sports $model */

$this->title = 'Create Sports';
$this->params['breadcrumbs'][] = ['label' => 'Sports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
