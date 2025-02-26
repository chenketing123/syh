<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>


    <?= $form->field($model, 'category_id')->textInput(['maxlength' => true])->dropDownList(\backend\models\BookCategory::getList()) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>


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
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
