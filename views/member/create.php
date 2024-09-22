<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Member */
/* @var $modelUser app\models\BackendUser */
$this->title                   = 'Register';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['member/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="member-create">

    <div class="container">

        <?php
        if (!Yii::$app->user->isGuest && Yii::$app->user->identity->user_type == 1) { ?> 
            <?php
            echo $this->render('_form', [
                'model'     => $model,
                'modelUser' => $modelUser,
            ]);
        } else {
            ?>
            <h1>Method Not Allowed (#405)</h1>
        <?php } ?>
    </div>
</div>