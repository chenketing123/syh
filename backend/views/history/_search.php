<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\search\HistorySearch */
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

    <?= $form->field($model, 'code',['options'=>['tag'=>false]]) ?>

    <?= $form->field($model, 'name',['options'=>['tag'=>false]]) ?>

    <?= $form->field($model, 'time',['options'=>['tag'=>false]]) ?>

    <?= $form->field($model, 'number1',['options'=>['tag'=>false]]) ?>

    <?php // echo  $form->field($model, 'number2',['options'=>['tag'=>false]]) ?>

    <?php // echo  $form->field($model, 'number3',['options'=>['tag'=>false]]) ?>

    <?php // echo  $form->field($model, 'number4',['options'=>['tag'=>false]]) ?>

    <?php // echo  $form->field($model, 'number5',['options'=>['tag'=>false]]) ?>

    <?php // echo  $form->field($model, 'number6',['options'=>['tag'=>false]]) ?>

    <?php // echo  $form->field($model, 'created_at',['options'=>['tag'=>false]]) ?>

    <div class="pull-right col-xs-12 col-sm-2 col-md-2 col-lg-2">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <a class="btn btn-primary" href=" <?= \yii\helpers\Url::to(['daochu','message'=>Yii::$app->request->get()])?>">导出</a>
    </div>

    <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
