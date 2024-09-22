<?php

use app\models\EventSports;
use app\models\EventSportsSearch;
use app\models\EventsSearch;
use app\models\EventTeamsSearch;
use app\models\Sports;
use app\models\Teams;
use app\models\Venues;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\events $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="container">
    <div class="card  shadow-lg">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-8 col-sm-8">
                    <h3><?= Html::encode($this->title) ?></h3>
                </div>

                <?php if(buttonVisibility()==true){ ?>
                <div class="col-lg-4 col-sm-4 text-right">

                    <p>
                        <?= Html::a('<i class="fas fa-edit  fa-lg"></i> Update  ', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?= Html::a(' <i class="fas fa-trash  fa-lg"></i> Delete   ', ['delete', 'id' => $model->id], [
                            "template" => "",
                            'type' => "button",
                            'class' => 'btn btn-danger ',

                            'data' => [
                                'confirm' => 'Are you sure you want to delete this item?',
                                'method' => 'post',
                            ],
                        ]) ?>
                    </p>
                </div>
                <?php }?>
            </div>

        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name:ntext',
                    'date_from',
                    'date_to',
                    'description:ntext',
                    [
                        'attribute'     => 'is_active',
                        'format'        => 'html',
                        'label'         => 'Status',
                        'value'         => function ($data) {
                            return $data['is_active'] == false ? "Disabled" : "Active";
                        }
                    ],
                    [
                        'attribute'     => 'is_publish',
                        'format'        => 'html',
                        'label'         => 'Publicly available',
                        'value'         => function ($data) {
                            return $data['is_publish'] == false ? "Not yet published" : "Published";
                        }
                    ],
                    'created_at',
                    'updated_at',
                    'author_id',
                ],
            ]) ?>
            <br />
            <?php
            $searchModel  = new EventSportsSearch(['event_id' => $model->id]);
            $dataProvider = $searchModel->search(['event_id' => $model->id]);
            $attachments  = $dataProvider->getTotalCount();
            if ($attachments) {
            ?>
                <br>
                <h4>Sports / Competitions</h4>
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'options'      => ['class' => 'table-responsive table-hover  border-1 '],
                    'pager'        => [
                        'class'                => '\yii\bootstrap4\LinkPager',
                    ],
                    'columns'      => [
                        [
                            'attribute'     => 'sport_id',
                            'format'        => 'html',
                            'label'         => 'Sport / Competition',
                            'value'         => function ($data) {
                                return Sports::findOne(['id' => $data['sport_id']])->name;
                            }
                        ],
                        [
                            'attribute'     => 'venue_id',
                            'format'        => 'html',
                            'label'         => 'Venue',
                            'value'         => function ($data) {
                                return Venues::findOne(['id' => $data['venue_id']])->name;
                            }
                        ],
                        'max_score',
                        'description',
                    ],
                ]);
            } else { ?>
                <h3>No Sports / Competitions</h3>
            <?php }
            ?>
            <br />

            <?php
            $team_search_model  = new EventTeamsSearch(['event_id' => $model->id]);
            $team_data_provider = $team_search_model->search(['event_id' => $model->id]);
            $teams  = $team_data_provider->getTotalCount();
            if ($teams) {
            ?>
                <br>
                <h4>Competing Teams / Departments</h4>
                <?php
                echo GridView::widget([
                    'dataProvider' => $team_data_provider,
                    'options'      => ['class' => 'table-responsive table-hover  border-1 '],
                    'pager'        => [
                        'class'                => '\yii\bootstrap4\LinkPager',
                    ],
                    'columns'      => [
                        [
                            'attribute'     => 'team_id',
                            'format'        => 'html',
                            'label'         => 'Team / Department',
                            'value'         => function ($data) {
                                $team = Teams::findOne(['id' => $data['team_id']]);
                                return $team->name . ' (' . $team->description . ') ';
                            }
                        ],
                        'description',
                    ],
                ]);
            } else { ?>
                <h3>No Competing Teams</h3>
            <?php }
            ?>
            <br />




        </div>
    </div>
</div>
<br />

<?php
function buttonVisibility()
{
    if (Yii::$app->user->isGuest) {
        return false;
    }

    if (!Yii::$app->user->isGuest) {
        switch (Yii::$app->user->identity->user_type) {
            case 1:
                return true;
                break;
            case 2:
                return false;
                break;
            case 3:
                return false;
                break;
            case 4:
                return true;
                break;
            case 5:
                return false;
                break;
        }
    }
}
?>