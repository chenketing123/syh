<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
if($model->time>0){
    $model->time=date('Y-m-d H:i', $model->time);
}
/* @var $this yii\web\View */
/* @var $model backend\models\History */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'number1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number3')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number4')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number5')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number6')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'number7')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time', ['options' => ['tag' => false]])->widget(
        \kartik\datetime\DateTimePicker::className(), [
            'pluginOptions' => [
                'language' => 'zh-CN',
                'format' => 'yyyy-mm-dd hh:ii',
                'todayHighlight' => true,
                'autoclose' => true,
                'todayBtn' => true,
                'minView' => 'hour',
            ]]
    )?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
