<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
if(is_numeric($model->start_time)){
    if($model->start_time==0){
        $model->start_time='';
    }else{
        $model->start_time=date('Y-m-d',$model->start_time);
    }
}

if(is_numeric($model->end_time)){
    if($model->end_time==0){
        $model->end_time='';
    }else{
        $model->end_time=date('Y-m-d',$model->end_time);
    }
}
/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'mobile_phone')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'business')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'head_image')->widget('backend\widgets\webuploader\Image', [
        'boxId' => 'head_image',
        'options' => [
            'multiple' => false,
        ]
    ]) ?>

    <?= $form->field($model, 'company_image[]')->widget('backend\widgets\webuploader\Image', [
        'boxId' => 'company_image',
        'options' => [
            'multiple' => true
        ]
    ]) ?>


    <?= $form->field($model, 'is_vip')->radioList([1=>'是',0=>'否']) ?>


    <?= $form->field($model, 'is_answer')->radioList([1=>'是',0=>'否']) ?>


    <?= $form->field($model, 'start_time', ['options' => ['tag' => false]])->widget(
        \kartik\datetime\DateTimePicker::className(), [
            'pluginOptions' => [
                'language' => 'zh-CN',
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
                'minView' => 'month',
            ]]
    )?>

    <?= $form->field($model, 'end_time', ['options' => ['tag' => false]])->widget(
        \kartik\datetime\DateTimePicker::className(), [
            'pluginOptions' => [
                'language' => 'zh-CN',
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
                'minView' => 'month',
            ]]
    )?>


    <?= $form->field($model, 'dmts')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'fhmc')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'hubh')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'snzy')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'zw')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sex_value')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'id_card')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'zb')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'csny')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'year')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'month')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'day')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'jl')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'xsskc')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'xl')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'scjf')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'yf')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'hfdq')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'nxse')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ygs')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'hy')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'goods')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sfss')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sssj')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'gsqy')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'gsdz')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sjrdz')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sjrxm')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sjrdh')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'tjr')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'jjlxr')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'qylxr')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sfkp')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'kpzl')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'dytj')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
