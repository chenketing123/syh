<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
if($model->industry){
    $model->industry=explode(',',$model->industry);

}

/* @var $this yii\web\View */
/* @var $model backend\models\Company */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="company-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'industry')->widget(\kartik\select2\Select2::classname(), [
        'data'=>\backend\models\CompanyCategory::getList(),
        'options' => [
            'placeholder' => '请选择 ...',
            'multiple' => true,
        ],


    ]); ?>



    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'image')->widget('backend\widgets\webuploader\Image', [
        'boxId' => 'image',
        'options' => [
            'multiple' => false,
        ]
    ]) ?>

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
