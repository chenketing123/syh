<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\QuestionAnswer */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-answer-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'question_id', ['options' => ['tag' => false]])->widget(\kartik\select2\Select2::classname(), [
        'data' => \backend\models\Question::getList(),
        'options' => [
            'placeholder' => '请选择 ...',
            'multiple' => false,
        ],
        'pluginOptions' => [
            'allowClear' => true
        ]


    ]); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'head_image')->widget('backend\widgets\webuploader\Image', [
        'boxId' => 'head_image',
        'options' => [
            'multiple' => false,
        ]
    ]) ?>





    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
