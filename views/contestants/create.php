<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\contestants $model */

$this->title = 'Create Contestants';
$this->params['breadcrumbs'][] = ['label' => 'Contestants', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contestants-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
