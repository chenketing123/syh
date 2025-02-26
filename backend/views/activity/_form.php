<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

if(is_numeric($model->start_time)){
    if($model->start_time==0){
        $model->start_time=date('Y-m-d H:i:s');
    }else{
        $model->start_time=date('Y-m-d H:i:s',$model->start_time);
    }
}

if(is_numeric($model->end_time)){
    if($model->end_time==0){
        $model->end_time=date('Y-m-d H:i:s');
    }else{
        $model->end_time=date('Y-m-d H:i:s',$model->end_time);
    }
}
/* @var $this yii\web\View */
/* @var $model backend\models\Activity */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type')->radioList([1=>'普通',2=>'跳转其他小程序']) ?>

    <?= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_time', ['options' => ['tag' => false]])->widget(
        \kartik\datetime\DateTimePicker::className(), [
            'pluginOptions' => [
                'language' => 'zh-CN',
                'format' => 'yyyy-mm-dd hh:ii:ss',
                'autoclose' => true,
                'minView' => 'hour',
            ]]
    )?>

    <?= $form->field($model, 'end_time', ['options' => ['tag' => false]])->widget(
        \kartik\datetime\DateTimePicker::className(), [
            'pluginOptions' => [
                'language' => 'zh-CN',
                'format' => 'yyyy-mm-dd hh:ii:ss',
                'autoclose' => true,
                'minView' => 'hour',
            ]]
    )?>

    <?= $form->field($model, 'image')->widget('backend\widgets\webuploader\Image', [
        'boxId' => 'image',
        'options' => [
            'multiple' => false,
        ]
    ]) ?>



    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>
    <?= $form->field($model, 'status')->radioList(\backend\models\Activity::$status_message) ?>
    <?= $form->field($model, 'is_index')->radioList([1=>'是',0=>'否']) ?>

    <?= $form->field($model, 'info')->widget('kucha\ueditor\UEditor', [
        'clientOptions' => [
            //编辑区域大小
            'initialFrameHeight' => '300',
        ]
    ]); ?>

    <?= $form->field($model, 'content')->widget('kucha\ueditor\UEditor', [
        'clientOptions' => [
            //编辑区域大小
            'initialFrameHeight' => '300',
        ]
    ]); ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
