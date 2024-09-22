<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\HimRoute $model */

$this->title = 'Update Him Route: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Him Routes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="him-route-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
