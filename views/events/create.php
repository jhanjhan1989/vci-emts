<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\events $model */

$this->title = 'Create Events';
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">

 

    <?= $this->render('_form', [
        'model' => $model,
        'sports'=>$sports,
        'teams'=>$teams
        
    ]) ?>

</div>
