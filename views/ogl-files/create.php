<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\OglFiles $model */

$this->title = 'Create Ogl Files';
$this->params['breadcrumbs'][] = ['label' => 'Ogl Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ogl-files-create">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
