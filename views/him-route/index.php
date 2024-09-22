<?php

use app\models\HimRoute;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\HimRouteSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Him Routes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="him-route-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Him Route', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'route_date',
            'him_id',
            'from_staff:ntext',
            'to_staff:ntext',
            //'instructions:ntext',
            //'action_taken:ntext',
            //'due_date',
            //'created_at',
            //'updated_at',
            //'author_id',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, HimRoute $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
