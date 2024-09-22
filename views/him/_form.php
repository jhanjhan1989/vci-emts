<?php

use app\models\HimFiles;
use app\models\HimRoute;
use wbraganca\dynamicform\DynamicFormWidget;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\him $model */
/** @var yii\widgets\ActiveForm $form */
?>
<?php
// $route_history = [new HimRoute()];
$js = '
                        jQuery(".dynamicform_wrapper").on("afterInsert", function(e, item) {
                            var nIndex=0;
                            jQuery(".dynamicform_wrapper .panel-title-issue").each(function(index) {
                                jQuery(this).html((index + 1));
                                nIndex++;
                            });
                    
                        });

                        jQuery(".dynamicform_wrapper").on("afterDelete", function(e) {
                            var nIndex=0;
                            jQuery(".dynamicform_wrapper .panel-title-issue").each(function(index) {
                            
                                jQuery(this).html( (index + 1));
                                nIndex++;
                            });
                        
                        });';

$js2 = '
                        jQuery(".route_dynamic_form").on("afterInsert", function(e, item) {
                            var nIndex=0;
                            jQuery(".route_dynamic_form .panel-title-route").each(function(index) {
                                jQuery(this).html((index + 1));
                                nIndex++;
                            });
                    
                        });

                        jQuery(".route_dynamic_form").on("afterDelete", function(e) {
                            var nIndex=0;
                            jQuery(".route_dynamic_form .panel-title-route").each(function(index) {
                                jQuery(this).html( (index + 1));
                                nIndex++;
                            });
                        
                        });';

$this->registerJs($js);
$this->registerJs($js2);

?>
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
                echo $model->id ? 'Update  ' .  "HIM-" .  date_format(date_create($model->control_date), "M-y-") . str_pad($model->control_no, 3, "0", STR_PAD_LEFT)  : "New Entry"  ?>

            </div>
            <div class="col-lg-3 col-sm-3 text-right">
                <?= Html::a('<i class="fas fa-times  fa-lg"></i>', ['index'], ["template" => "", 'type' => "button", 'class' => 'btn btn-tool', "data-widget" => "remove"]) ?>

            </div>
        </div>

    </div>
    <div class="card-body">

        <?= $form->field($model, 'stakeholder')->textInput() ?>
        <div class="row">
            <div class="col-lg-6 col-sm-6">
                <?= $form->field($model, 'organization')->textInput() ?>
            </div>
            <div class="col-lg-6 col-sm-6">
                <?= $form->field($model, 'position')->textInput() ?>
            </div>
        </div>

        <?= $form->field($model, 'information_requested')->textInput() ?>
        <?= $form->field($model, 'purpose')->textInput() ?>

        <?php
        if ($model->id != 0) {
        ?>
            <div class="row">
                <div class="col-lg-1 col-sm-2">
                    <?= $form->field($model, 'no_of_disc')->textInput(['type' => 'number']) ?>
                </div>
                <div class="col-lg-1 col-sm-2">
                    <?= $form->field($model, 'no_of_print')->textInput(['type' => 'number']) ?>
                </div>
                <div class="col-lg-4 col-sm-4">
                    <?= $form->field($model, 'status')->textInput() ?>
                </div>
                <div class="col-lg-3 col-sm-3">
                    <?php
                    echo $form->field($model, 'date_issued')->textInput(['type' => 'date', 'value' => $model->date_issued ? date_format(date_create($model->date_issued), "Y-m-d") : null]);
                    ?>
                </div>
                <div class="col-lg-3 col-sm-3">
                    <?php
                    echo $form->field($model, 'date_released')->textInput(['type' => 'date', 'value' => $model->date_released ? date_format(date_create($model->date_released), "Y-m-d") : null]);
                    ?>
                </div>

            </div>
        <?php
        } else {
        ?>
            <div class="row">
                <div class="col-lg-4 col-sm-4">
                    <?= $form->field($model, 'no_of_disc')->textInput(['type' => 'number']) ?>
                </div>
                <div class="col-lg-4 col-sm-4">
                    <?= $form->field($model, 'no_of_print')->textInput(['type' => 'number']) ?>
                </div>
                <div class="col-lg-4 col-sm-4">
                    <?= $form->field($model, 'status')->textInput() ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-sm-1">
                    <?= $form->field($model, 'staff_source')->textInput() ?>
                </div>
                <div class="col-md-4 col-sm-1">
                    <?= $form->field($model, 'staff_responsible')->textInput() ?>
                </div>
                <div class="col-md-4 col-sm-1">
                    <?= $form->field($model, 'reference_gil')->textInput() ?>
                </div>
            </div>
        <?php

        }
        ?>


        <div class="mb-2 mt-3 ">
            <?php
            $_model_item = [new HimFiles()];
            DynamicFormWidget::begin([
                'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody'      => '.container-items', // required: css class selector
                'widgetItem'      => '.item', // required: css class
                'limit'           => 100, // the maximum times, an element can be cloned (default 999)
                'min'             => 1, // 0 or 1 (default 1)
                'insertButton'    => '.add-item', // css class
                'deleteButton'    => '.remove-item', // css class
                'model'           => $_model_item[0],
                'formId'          => 'dynamic-form',
                'formFields'      => [
                    'id',
                    'title',
                    'description',
                    'imageFile'
                ],
            ]);
            ?>

            <blockquote class="quote-secondary">
                <div class="row">
                    <div class="col-lg-9 col-sm-12">
                        <h5>Files/ Attachments</h5>
                        <p>You may upload the electronic/ digital copy of the document</p>
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
                                <td>Title*</td>
                                <td>Description*</td>
                                <td>Browse File</td>
                                <td>
                                </td>
                            </tr>

                        </thead>
                        <tbody>

                            <?php foreach ($attachments as $index => $item) : ?>

                                <tr class="item mb-0 mt-0">
                                    <td valign="middle" class="mb-0 mt-0" width="20">
                                        <span class="panel-title-issue">
                                            <?php print $index + 1 ?>
                                        </span>

                                        <?php
                                        // necessary for update action.

                                        echo $form->field($item, "[$index]updated_at")->hiddenInput()->label(false);
                                        echo $form->field($item, "[$index]created_at")->hiddenInput()->label(false);
                                        echo $form->field($item, "[$index]file_name")->hiddenInput()->label(false);
                                        echo $form->field($item, "[$index]file_type")->hiddenInput()->label(false);
                                        echo $form->field($item, "[$index]file_size")->hiddenInput()->label(false);
                                        echo $form->field($item, "[$index]file_path")->hiddenInput()->label(false);
                                        echo $form->field($item, "[$index]him_id")->hiddenInput()->label(false);
                                        echo $form->field($item, "[$index]id")->hiddenInput()->label(false);

                                        ?>
                                    </td>
                                    <td valign="middle" class="mb-0 mt-0">
                                        <?= $form->field($item, "[{$index}]title")
                                            ->textInput()
                                            ->label(FALSE); ?>
                                    </td>
                                    <td valign="middle" class="mb-0 mt-0">
                                        <?= $form->field($item, "[{$index}]description")
                                            ->textInput()
                                            ->label(FALSE); ?>
                                    </td>
                                    <td>
                                        <?=
                                        $form->field($item, "[{$index}]imageFile")->fileInput()->label(false);
                                        ?>
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

        <div class="mb-2 mt-3 ">
            <?php
            $_route_item = [new HimRoute()];
            DynamicFormWidget::begin([
                'widgetContainer' => 'route_dynamic_form', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                'widgetBody'      => '.container-route-items', // required: css class selector
                'widgetItem'      => '.item-route', // required: css class
                'limit'           => 100, // the maximum times, an element can be cloned (default 999)
                'min'             => 1, // 0 or 1 (default 1)
                'insertButton'    => '.add-item-route', // css class
                'deleteButton'    => '.remove-item-route', // css class
                'model'           => $route_history[0],
                'formId'          => 'dynamic-form',
                'formFields'      => [
                    'id',
                    'from_staff',
                    'to_staff',
                    'instructions'
                ],
            ]);
            ?>

            <blockquote class="quote-secondary">
                <div class="row">
                    <div class="col-lg-9 col-sm-12">
                        <h5>Route History</h5>
                        <p>Track your documents by viewing the list below or adding an entry.</p>
                    </div>
                    <div class="col-lg-3 col-sm-12 text-lg-right mb-3">
                        <button type="button" class=" add-item-route btn btn-success  btn-sm"><i class="fa fa-plus fa-sm"></i>
                            Add
                            Row</button>
                    </div>
                </div>
                <div class="overflow-auto">
                    <table class="table bg-transparent   container-route-items">
                        <thead class="font-weight-bold">
                            <tr class="">
                                <td>No.</td>
                                <td>Date*</td>
                                <td>From / Origin*</td>
                                <td>Forwarded To *</td>
                                <td>Instructions</td>
                                <td>Action Taken</td>
                                <td>

                                </td>
                            </tr>

                        </thead>
                        <tbody>

                            <?php

                            foreach ($route_history as $index => $item) : ?>
                                <tr class="item-route mb-0 mt-0">
                                    <td valign="middle" class="mb-0 mt-0" width="20">
                                        <span class="panel-title-route">
                                            <?php print $index + 1 ?>
                                        </span>

                                        <?php
                                        // necessary for update action.

                                        echo $form->field($item, "[$index]updated_at")->hiddenInput()->label(false);
                                        echo $form->field($item, "[$index]created_at")->hiddenInput()->label(false);
                                        echo $form->field($item, "[$index]him_id")->hiddenInput()->label(false);
                                        echo $form->field($item, "[$index]id")->hiddenInput()->label(false);

                                        ?>
                                    </td>
                                    <td valign="middle" class="mb-0 mt-0">
                                        <?= $form->field($item, "[{$index}]route_date")
                                            ->textInput(['type' => 'date'])
                                            ->label(FALSE); ?>
                                    </td>
                                    <td valign="middle" class="mb-0 mt-0">
                                        <?= $form->field($item, "[{$index}]from_staff")
                                            ->textInput()
                                            ->label(FALSE); ?>
                                    </td>
                                    <td valign="middle" class="mb-0 mt-0">
                                        <?= $form->field($item, "[{$index}]to_staff")
                                            ->textInput()
                                            ->label(FALSE); ?>
                                    </td>
                                    <td>
                                        <?= $form->field($item, "[{$index}]instructions")
                                            ->textInput()
                                            ->label(FALSE); ?>
                                    </td>
                                    <td>
                                        <?= $form->field($item, "[{$index}]action_taken")
                                            ->textInput()
                                            ->label(FALSE); ?>
                                    </td>
                                    <td valign="middle" class="mb-0 mt-0" width="20"><button type="button" class="remove-item-route btn btn-danger btn-sm"><i class="fa  fa-trash-alt" aria-hidden="true"></i>

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
<br>