<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UserTable $model */

$this->title = 'Create User Table';
$this->params['breadcrumbs'][] = ['label' => 'User Tables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-table-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
