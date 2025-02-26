<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\UserIcon */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-icon-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image')->widget('backend\widgets\webuploader\Image', [
        'boxId' => 'image',
        'options' => [
            'multiple' => false,
        ]
    ]) ?>


    <?= $form->field($model, 'image2')->widget('backend\widgets\webuploader\Image', [
        'boxId' => 'image2',
        'options' => [
            'multiple' => false,
        ]
    ]) ?>

    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'type')->dropDownList(\backend\models\UserIcon::$type_message) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
