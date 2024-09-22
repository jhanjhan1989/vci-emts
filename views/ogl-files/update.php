<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\OglFiles $model */

$this->title = 'Update Ogl Files: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Ogl Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ogl-files-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
