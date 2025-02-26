<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$action=Yii::$app->controller->action->id;

/* @var $this yii\web\View */
/* @var $model backend\search\CodeSearch */
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


    <?= $form->field($model, 'value',['options'=>['tag'=>false]]) ?>

    <?= $form->field($model, 'status',['options'=>['tag'=>false]])->dropDownList(\backend\models\Code::$status_message,['prompt'=>'']) ?>


                <?= $form->field($model, 'type',['options'=>['tag'=>false]])->hiddenInput()->label(false) ?>
    <div class="pull-right col-xs-12 col-sm-2 col-md-2 col-lg-2">
        <?= Html::submitButton('搜索', ['class' => 'btn btn-primary']) ?>
        <?php if($action=='index'){?>
        <a href="<?= \yii\helpers\Url::to(['code2'])?>" class="btn btn-primary">生成二维码</a>
        <?php }?>
        <?php if($action=='index2'){?>
            <a href="<?= \yii\helpers\Url::to(['code3'])?>" class="btn btn-primary">生成二维码</a>
        <?php }?>
        <?php if($action=='index3'){?>
            <a href="<?= \yii\helpers\Url::to(['code4'])?>" class="btn btn-primary">生成二维码</a>
        <?php }?>
    </div>

    <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
</div>
