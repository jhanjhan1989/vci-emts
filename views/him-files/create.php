<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\himfiles $model */

$this->title = 'Create File';
$this->params['breadcrumbs'][] = ['label' => 'HIM Attachments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="himfiles-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
