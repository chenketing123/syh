<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\TeamBook */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="team-book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'team_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'book_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'detail_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'time')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
