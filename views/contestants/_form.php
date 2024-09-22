<?php

use app\models\Contestants;
use app\models\EventTeams;
use app\models\EventTeamsSearch;
use app\models\ScoreCard;
use app\models\Teams;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\eventsports $model */
/** @var yii\widgets\ActiveForm $form */

$js = '
                        jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
                            var nIndexi=0;
                            jQuery(".dynamicform_wrapper .panel-title-issue").each(function(index) {
                                jQuery(this).html((index + 1));
                                nIndexi++;
                            });
                    
                        });

                        jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
                            var nIndexi=0;
                            jQuery(".dynamicform_wrapper .panel-title-issue").each(function(index) {
                                jQuery(this).html( (index + 1));
                                nIndexi++;
                            });
                        
                        });';

$this->registerJs($js);


?>


<div class="container">
    <?php $form = ActiveForm::begin([
        'options' => [
            'enctype' => 'multipart/form-data',
            'id'      => 'dynamic-form'
        ]
    ]);
    ?>
    <div class="card  shadow-lg mb-5">
        <div class="card-header h3">
            <div class="row">
                <div class="col-lg-9 col-sm-9">
                    <?php
                    // necessary for update action.
                    echo $form->field($model, "updated_at")->hiddenInput()->label(false);
                    echo $form->field($model, "created_at")->hiddenInput()->label(false);
                    echo $form->field($model, "is_deleted")->hiddenInput()->label(false);
                    echo $form->field($model, "is_active")->hiddenInput()->label(false);
                    echo $form->field($model, "author_id")->hiddenInput()->label(false);
                    echo $form->field($model, "event_id")->hiddenInput()->label(false);
                    echo $form->field($model, "sport_id")->hiddenInput()->label(false);
                     
                    ?>
                    <?php
                    echo $model->id ? 'Update Players/ Contestants' : "New Contestant"  ?>

                </div>
                <div class="col-lg-3 col-sm-3 text-right">
                    <?= Html::a('<i class="fas fa-times  fa-lg"></i>', ['index'], ["template" => "", 'type' => "button", 'class' => 'btn btn-tool', "data-widget" => "remove"]) ?>

                </div>
            </div>

        </div>
        <div class="card-body">
            <?= $form->field($model, "event_id")
                ->dropDownList(
                    $model->getEvents(),
                    [
                        'prompt' => 'Please choose an event',
                        'style' => 'width: 100%;',
                        'disabled' => 'true',
                        // 'class'=>'bg-secondary form-control'

                    ]
                );
            ?>

            <div class="row">
                <div class="col-md-5">
                    <?= $form->field($model, "sport_id")
                        ->dropDownList(
                            $model->getSports(),
                            [
                                'prompt' => 'Please choose a sport/competition',
                                'style' => 'width: 100%;',
                                'disabled' => 'true',

                            ]
                        );
                    ?>
                </div>
                <div class="col-md-5">
                    <?= $form->field($model, "venue_id")
                        ->dropDownList(
                            $model->getVenues(),
                            [
                                'prompt' => 'Please choose a venue',
                                'style' => 'width: 100%;',
                                'disabled' => 'true',

                            ]
                        );
                    ?>
                </div>
                <div class="col-md-2">
                    <?= $form->field($model, 'max_score')->textInput(['disabled' => 'true',]) ?>

                </div>
            </div>

            <hr />
            <div class="mb-2 mt-3 ">
                <?php
                // $_model_item = [new EventSports([])];
                DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody'      => '.container-items', // required: css class selector
                    'widgetItem'      => '.item', // required: css class
                    'limit'           => 100, // the maximum times, an element can be cloned (default 999)
                    'min'             => 1, // 0 or 1 (default 1)
                    'insertButton'    => '.add-item', // css class
                    'deleteButton'    => '.remove-item', // css class
                    'model'           =>  new EventTeams(),
                    'formId'          => 'dynamic-form',
                    'formFields'      => [
                        'id',
                        'event_id',
                        'sport_id',
                        'venue_id',
                        'contestant',
                    ],
                ]);
                ?>

                <div class="">
                    <div class="row">
                        <div class="col-lg-12 col-sm-12">
                            <h5 class="mb-0">List of Players or Contestant</h5>
                            <p class="small text-muted">Provide the details of participating players for this sport/competition</p>
                        </div>

                    </div>
                    <div class="overflow-auto">
                        <table class="table bg-transparent table-bordered table-hover    container-items">
                            <thead class="font-weight-bold">
                                <tr class="">
                                    <td>No.</td>
                                    <td>Team / Department*</td>
                                    <td>Contestant / Player</td>
                                </tr>

                            </thead>
                            <tbody>

                                <?php foreach ($teams as $index => $item) : ?>

                                    <tr class="item mb-0 mt-0">
                                        <td valign="middle" class="mb-0 mt-0" width="20">
                                            <span class="panel-title-issue">
                                                <?php print $index + 1 ?>
                                            </span>

                                            <?php
                                            // necessary for update action.
                                            echo $form->field($item, "[$index]updated_at")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]created_at")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]is_deleted")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]is_active")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]author_id")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]event_id")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]team_id")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]score")->hiddenInput(['value'=>0])->label(false);
                                            echo $form->field($item, "[$index]remarks")->hiddenInput(['value'=>'--'])->label(false);


                                            ?>
                                        </td>
                                        <td valign="middle" class="mb-0 mt-0">
                                            <?php
                                            $team = Teams::findOne($item->team_id);
                                            echo $team->name . ' - ' . $team->description;

                                            ?>
                                        </td>
                                       
                                        <td valign="middle" class="mb-0 mt-0">
                                            <?php
                                            $query = Contestants::find()->where([
                                                'event_id' => $model->event_id,
                                                'team_id' => $item->team_id,
                                                'sport_id' => $model->sport_id
                                            ])->one();
                                            $contestant = $query != null ? $query->name : '';
                                            // $remarks = $query != null ? $query->remarks : '';

                                            ?>
                                            <?= $form->field($item, "[{$index}]contestant")
                                                ->textInput([ 
                                                    'value' => $contestant,
                                                    'placeholder'=>'Provide contestant / player info here.'
                                                ])
                                                ->label(FALSE); ?>
                                        </td>
                                       
                                    </tr>

                                <?php endforeach; ?>
                            </tbody>

                        </table>

                    </div>


                </div>
                <?php DynamicFormWidget::end(); ?>
            </div>



        </div>
        <div class="card-footer">
            <div class="form-group float-right">
                <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
            </div>
        </div>

    </div>




    <?php ActiveForm::end(); ?>


</div>

<br>