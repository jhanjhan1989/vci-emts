<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\HimRoute $model */

$this->title = 'Create Him Route';
$this->params['breadcrumbs'][] = ['label' => 'Him Routes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="him-route-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
