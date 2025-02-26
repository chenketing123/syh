<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
$type=Yii::$app->request->get('type');
if($type==2){
    $model->type=2;
}

/* @var $this yii\web\View */
/* @var $model backend\models\question */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="question-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($model, 'type')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?php if($model->type==2){?>
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?php }?>
    <?= $form->field($model, 'user_id', ['options' => ['tag' => false]])->widget(\kartik\select2\Select2::classname(), [
        'data' => \backend\models\User::getList(),
        'options' => [
            'placeholder' => '请选择 ...',
            'multiple' => false,
        ],
        'pluginOptions' => [
            'allowClear' => true
        ]


    ]); ?>


    <?= $form->field($model, 'category_id', ['options' => ['tag' => false]])->widget(\kartik\select2\Select2::classname(), [
        'data' => \backend\models\QuestionCategory::getList(),
        'options' => [
            'placeholder' => '请选择 ...',
            'multiple' => false,
        ],
        'pluginOptions' => [
            'allowClear' => true
        ]


    ]); ?>


    <?php if($model->type==1){?>
        <?= $form->field($model, 'status')->dropDownList(\backend\models\Question::$status_message) ?>

    <?php }?>

    <?= $form->field($model, 'content')->textarea(['rows'=>5]);?>


    <?php if($model->type==2){?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'position')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'head_image')->widget('backend\widgets\webuploader\Image', [
            'boxId' => 'head_image',
            'options' => [
                'multiple' => false,
            ]
        ]) ?>

    <?php }?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
