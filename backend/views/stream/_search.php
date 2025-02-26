<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\search\StreamSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>查询</h5>
            </div>
            <div class="ibox-content">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
                'options'=>['class'=>'form-horizontal'],
                'fieldConfig'=> [
                'template' =>"<div class='col-sm-4 col-xs-6'> <div class='input-group m-b'> <div class='input-group-btn'>{label}</div>{input}</div></div>",
                'labelOptions' => ['class' => 'btn btn-primary'],
                ]

    ]); ?>

    <?= $form->field($model, 'id',['options'=>['tag'=>false]]) ?>

    <?= $form->field($model, 'name',['options'=>['tag'=>false]]) ?>

    <?= $form->field($model, 'lng',['options'=>['tag'=>false]]) ?>

    <?= $form->field($model, 'lat',['options'=>['tag'=>false]]) ?>

    <?= $form->field($model, 'area',['options'=>['tag'=>false]]) ?>

    <?php // echo  $form->field($model, 'number',['options'=>['tag'=>false]]) ?>

    <?php // echo  $form->field($model, 'level',['options'=>['tag'=>false]]) ?>

    <?php // echo  $form->field($model, 'river_system',['options'=>['tag'=>false]]) ?>

    <?php // echo  $form->field($model, 'street',['options'=>['tag'=>false]]) ?>

    <?php // echo  $form->field($model, 'maintenance',['options'=>['tag'=>false]]) ?>

    <?php // echo  $form->field($model, 'area_2',['options'=>['tag'=>false]]) ?>

    <?php // echo  $form->field($model, 'sort',['options'=>['tag'=>false]]) ?>

    <div class="pull-right col-xs-12 col-sm-2 col-md-2 col-lg-2">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
