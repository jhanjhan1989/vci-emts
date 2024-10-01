<?php

use app\models\Contestants;
use app\models\Events;
use app\models\EventTeamsSearch;
use app\models\ScoreCard;
use app\models\Sports;
use app\models\Teams;
use app\models\Venues;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\eventsports $model */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Score Cards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
$event = Events::findOne($model->event_id);
$sport = Sports::findOne($model->sport_id);

$event_name = $event != null ? $event->name : '(Not Set)';
$sport_name = $sport != null ? $sport->name : '(Not Set)';
?>

<div class="container">
    <div class="card  shadow-lg">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-9 col-sm-9">
                    <h5>
                        <?php echo $event_name . '<small> >> </small>' . $sport_name; ?>
                    </h5>
                </div>
                <div class="col-lg-3 col-sm-3 text-right">

                    <p>
                        <?= Html::a('<i class="fas fa-edit  fa-lg"></i> Update  ', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                        <?php if (buttonVisibility()) {
                            echo Html::a(' <i class="fas fa-trash  fa-lg"></i> Delete   ', ['delete', 'id' => $model->id], [
                                "template" => "",
                                'type' => "button",
                                'class' => 'btn btn-danger ',

                                'data' => [
                                    'confirm' => 'Are you sure you want to delete this item?',
                                    'method' => 'post',
                                ],
                            ]);
                        } ?>

                        <?php if (!Yii::$app->user->isGuest && ( Yii::$app->user->identity->user_type == 2||Yii::$app->user->identity->user_type == 1)) {
                            echo Html::a(
                                ' <i class="fa fa-upload"></i> Publish   ',
                                ['publish', 'id' => $model->id,],
                                [
                                    "template" => "",
                                    'type' => "button",
                                    'class' => 'btn btn-success ',

                                    'data' => [
                                        'confirm' => 'Are you sure you want to publish this score card?',
                                        'method' => 'post',
                                    ],
                                ]
                            );
                        } ?>


                    </p>
                </div>
            </div>

        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute'     => 'event_id',
                        'format'        => 'html',
                        'label'         => 'Event Name',
                        'value'         =>  $event_name
                    ],
                    [
                        'attribute'     => 'sport_id',
                        'format'        => 'html',
                        'label'         => 'Sport / Competition',
                        'value'         =>  $sport_name
                    ],
                    [
                        'attribute'     => 'venue_id',
                        'format'        => 'html',
                        'label'         => 'Venue',
                        'value'         => function ($data) {
                            $sport = Venues::findOne($data['sport_id']);
                            return $sport != null ? $sport->name : '(Not Set)';
                        }
                    ],
                    'max_score',
                    'description:ntext',

                ],
            ]) ?>

            <br>
            <blockquote class="quote-success ">
                <div class="row">
                    <div class="col-lg-12 col-sm-12">
                        <h5>Score Sheet</h5>
                        <p>Shows the scores/ points acquired by each team</p>
                    </div>

                </div>
                <div class="overflow-auto">
                    <table class="table bg-transparent table-bordered table-hover    container-items">
                        <thead class="font-weight-bold">
                            <tr class="">
                                <td class="text-center">Rank</td>
                                <td>Team / Department*</td>
                                <td>Contestant / Player</td>
                                <td width="100">Score/ Points</td>
                                <td>Remarks*</td>
                            </tr>

                        </thead>
                        <tbody>

                            <?php foreach ($teams as $index => $item) : ?>

                                <tr class="item mb-0 mt-0">
                                    <td valign="middle" class="mb-0 mt-0 text-center" width="20">
                                        <span class="panel-title-issue">
                                            <?php print $index + 1 ?>
                                        </span>
                                    </td>
                                    <td valign="middle" class="mb-0 mt-0">
                                        <?php echo $item->team_name; ?>
                                    </td>
                                    <td valign="middle" class="mb-0 mt-0">
                                        <?php
                                        $player = Contestants::find()->where([
                                            'event_id' => $model->event_id,
                                            'team_id' => $item->team_id,
                                            'sport_id' => $model->sport_id
                                        ])->one();
                                        echo $player ? $player->name : '(Not Set)';
                                        ?>
                                    </td>
                                    <td valign="middle" class="mb-0 mt-0 text-center">
                                        <?php echo $item->score; ?>
                                    </td>
                                    <td valign="middle" class="mb-0 mt-0">
                                        <?php echo $item->remarks; ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </blockquote>
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