<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
/* @var $this yii\web\View */
/* @var $model backend\models\UserTeam */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-team-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if($model->isNewRecord){?>
        <?= $form->field($model, 'user_ids[]')->widget(Select2::classname(), [
            'data'=>\backend\models\User::getList(),
            'options' => [
                'placeholder' => '请选择 ...',
                'multiple' => true,
            ],


        ])->label('用户'); ?>
    <?php }?>



    <?= $form->field($model, 'sort')->textInput() ?>

    <?= $form->field($model, 'user_type')->radioList(\backend\models\UserTeam::$user_type) ?>



    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
