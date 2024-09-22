<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\HimRoute $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Him Routes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="him-route-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'route_date',
            'him_id',
            'from_staff:ntext',
            'to_staff:ntext',
            'instructions:ntext',
            'action_taken:ntext',
            'due_date',
            'created_at',
            'updated_at',
            'author_id',
        ],
    ]) ?>

</div>
