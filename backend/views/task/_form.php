<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
if(is_numeric($model->start_time)){
    if($model->start_time==0){
        $model->start_time=date('Y-m-d');
    }else{
        $model->start_time=date('Y-m-d',$model->start_time);
    }
}

if(is_numeric($model->end_time)){
    if($model->end_time==0){
        $model->end_time=date('Y-m-d');
    }else{
        $model->end_time=date('Y-m-d',$model->end_time);
    }
}
/* @var $this yii\web\View */
/* @var $model backend\models\Task */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="task-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>



    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'start_time', ['options' => ['tag' => false]])->widget(
        \kartik\datetime\DateTimePicker::class, [
            'pluginOptions' => [
                'language' => 'zh-CN',
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
                'minView' => 'month',
            ]]
    )?>

    <?= $form->field($model, 'end_time', ['options' => ['tag' => false]])->widget(
        \kartik\datetime\DateTimePicker::class, [
            'pluginOptions' => [
                'language' => 'zh-CN',
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
                'minView' => 'month',
            ]]
    )?>

    <?= $form->field($model, 'image')->widget('backend\widgets\webuploader\Image', [
        'boxId' => 'image',
        'options' => [
            'multiple' => false,
        ]
    ]) ?>



    <?= $form->field($model, 'type')->radioList([1=>'视频',2=>'图片']) ?>
    <div class="form-group field-task-video">
        <label class="control-label" for="task-video">视频上传</label>
        <input type="file" id="task-video" name="file" maxlength="255">

        <div class="help-block"></div>
    </div>




    <?= $form->field($model, 'video')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'sort')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
