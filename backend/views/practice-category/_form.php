<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\PracticeCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="practice-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'sort')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'parent_id')->textInput(['maxlength' => true]) ?>



    <?= $form->field($model, 'image')->widget('backend\widgets\webuploader\Image', [
        'boxId' => 'image',
        'options' => [
            'multiple' => false,
        ]
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
