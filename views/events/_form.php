<?php

use app\models\EventSports;
use app\models\EventTeams;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\events $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php
// $route_history = [new HimRoute()];
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

$js2 = '
                        jQuery(".team_wrapper").on("afterInsert", function(e, item) {
                            var nIndex=0;
                            jQuery(".team_wrapper .panel-title-teams").each(function(index) {
                                jQuery(this).html((index + 1));
                                nIndex++;
                            });
                    
                        });

                        jQuery(".team_wrapper").on("afterDelete", function(e) {
                            var nIndex=0;
                            jQuery(".team_wrapper .panel-title-teams").each(function(index) {
                                jQuery(this).html( (index + 1));
                                nIndex++;
                            });
                        
                        });';

$this->registerJs($js2);

?>
<?php $form = ActiveForm::begin([
    'options' => [
        'enctype' => 'multipart/form-data',
        'id'      => 'dynamic-form'
    ]
]);
?>
<div class="container">

    <div class="card  shadow-lg mb-5">
        <div class="card-header h3">
            <div class="row">
                <div class="col-lg-9 col-sm-9">
                    <?php
                    echo $model->id ? 'Update  ' .  $model->name : "New Entry"  ?>

                </div>
                <div class="col-lg-3 col-sm-3 text-right">
                    <?= Html::a('<i class="fas fa-times  fa-lg"></i>', ['index'], ["template" => "", 'type' => "button", 'class' => 'btn btn-tool', "data-widget" => "remove"]) ?>

                </div>
            </div>

        </div>
        <div class="card-body">

            <?= $form->field($model, 'name')->textInput() ?>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'description')->textInput() ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'date_from')->textInput(['type' => 'date',  'value' => date_format(date_create($model->date_from), "Y-m-d")]) ?>
                </div>
                <div class="col-md-3">
                    <?= $form->field($model, 'date_to')->textInput(['type' => 'date',  'value' => date_format(date_create($model->date_to), "Y-m-d")]) ?>
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
                    'model'           =>  new EventSports(),
                    'formId'          => 'dynamic-form',
                    'formFields'      => [
                        'id',
                        'event_id',
                        'sport_id',
                        'venue_id',
                        'description',
                    ],
                ]);
                ?>

                <blockquote class="quote-secondary">
                    <div class="row">
                        <div class="col-lg-9 col-sm-12">
                            <h5>Sports/ Competitions</h5>
                            <p>List down all the competitions/ sports during this event</p>
                        </div>
                        <div class="col-lg-3 col-sm-12 text-lg-right mb-3">
                            <button type="button" class="  add-item btn btn-success btn-sm"><i class="fas fa-plus fa-sm"></i>
                                Add Row</button>
                        </div>
                    </div>
                    <div class="overflow-auto">
                        <table class="table bg-transparent   container-items">
                            <thead class="font-weight-bold">
                                <tr class="">
                                    <td>No.</td>
                                    <td>Sport/ Competition*</td>
                                    <td>Venue</td>
                                    <td width="100">Max Score</td>
                                    <td>Description*</td>
                                    <td>
                                    </td>
                                </tr>

                            </thead>
                            <tbody>

                                <?php foreach ($sports as $index => $item) : ?>

                                    <tr class="item mb-0 mt-0">
                                        <td valign="middle" class="mb-0 mt-0" width="20">
                                            <span class="panel-title-issue">
                                                <?php print $index + 1 ?>
                                            </span>

                                            <?php
                                            // necessary for update action.
                                            echo $form->field($item, "[$index]updated_at")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]created_at")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]id")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]is_deleted")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]is_publish")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]is_active")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]author_id")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]event_id")->hiddenInput()->label(false);


                                            ?>
                                        </td>
                                        <td valign="middle" class="mb-0 mt-0">
                                            <?= $form->field($item, "[{$index}]sport_id")
                                                ->dropDownList($item->getSports(), ['prompt' => 'Select...'])
                                                ->label(FALSE); ?>
                                        </td>
                                        <td valign="middle" class="mb-0 mt-0">
                                            <?= $form->field($item, "[{$index}]venue_id")
                                                ->dropDownList($item->getVenues(), ['prompt' => 'Select...'])
                                                ->label(FALSE); ?>
                                        </td>
                                        <td valign="middle" class="mb-0 mt-0">
                                            <?= $form->field($item, "[{$index}]max_score")
                                                ->textInput()
                                                ->label(FALSE); ?>
                                        </td>
                                        <td valign="middle" class="mb-0 mt-0">
                                            <?= $form->field($item, "[{$index}]description")
                                                ->textInput()
                                                ->label(FALSE); ?>
                                        </td>

                                        <td valign="middle" class="mb-0 mt-0" width="20"><button type="button" class="remove-item btn btn-danger btn-sm"><i class="fa fa-trash-alt" aria-hidden="true"></i>

                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                            </tbody>

                        </table>

                    </div>


                </blockquote>
                <?php DynamicFormWidget::end(); ?>
            </div>

            <hr />
            <div class="mb-2 mt-3 ">
                <?php

                DynamicFormWidget::begin([
                    'widgetContainer' => 'team_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody'      => '.team-items', // required: css class selector
                    'widgetItem'      => '.item_team', // required: css class
                    'limit'           => 100, // the maximum times, an element can be cloned (default 999)
                    'min'             => 1, // 0 or 1 (default 1)
                    'insertButton'    => '.add-item-team', // css class
                    'deleteButton'    => '.remove-item-team', // css class
                    'model'           =>  new EventTeams(),
                    'formId'          => 'dynamic-form',
                    'formFields'      => [
                        'id',
                        'team_id',
                        'description',
                    ],
                ]);
                ?>

                <blockquote class="quote-secondary">
                    <div class="row">
                        <div class="col-lg-9 col-sm-12">
                            <h5>Competing Teams</h5>
                            <p>List down all the competing teams/ departments</p>
                        </div>
                        <div class="col-lg-3 col-sm-12 text-lg-right mb-3">
                            <button type="button" class="  add-item-team btn btn-success btn-sm"><i class="fas fa-plus fa-sm"></i>
                                Add Row</button>
                        </div>
                    </div>
                    <div class="overflow-auto">
                        <table class="table bg-transparent   team-items">
                            <thead class="font-weight-bold">
                                <tr class="">
                                    <td>No.</td>
                                    <td>Competing Teams*</td>
                                    <td>Description*</td>
                                    <td>
                                    </td>
                                </tr>

                            </thead>
                            <tbody>

                                <?php foreach ($teams as $index => $item) : ?>

                                    <tr class="item_team mb-0 mt-0">
                                        <td valign="middle" class="mb-0 mt-0" width="20">
                                            <span class="panel-title-teams">
                                                <?php print $index + 1 ?>
                                            </span>

                                            <?php
                                            // necessary for update action.
                                            echo $form->field($item, "[$index]updated_at")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]created_at")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]id")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]is_deleted")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]is_publish")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]is_active")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]author_id")->hiddenInput()->label(false);
                                            echo $form->field($item, "[$index]event_id")->hiddenInput()->label(false);

                                            ?>
                                        </td>
                                        <td valign="middle" class="mb-0 mt-0">
                                            <?= $form->field($item, "[{$index}]team_id")
                                                ->dropDownList($item->getTeams(), ['prompt' => 'Select...'])
                                                ->label(FALSE); ?>
                                        </td>

                                        <td valign="middle" class="mb-0 mt-0">
                                            <?= $form->field($item, "[{$index}]description")
                                                ->textInput()
                                                ->label(FALSE); ?>
                                        </td>

                                        <td valign="middle" class="mb-0 mt-0" width="20"><button type="button" class="remove-item-team btn btn-danger btn-sm"><i class="fa fa-trash-alt" aria-hidden="true"></i>

                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                            </tbody>

                        </table>

                    </div>


                </blockquote>
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