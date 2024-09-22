<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\sports $model */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sports', 'url' => ['index']];
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
            </div>

        </div>
        <div class="card-body">
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'name:ntext',
                    'description:ntext',
                    'is_active',
                    'created_at',
                    'updated_at',
                    'author_id',
                ],
            ]) ?>

        </div>
    </div> 
</div>
<br />
 
