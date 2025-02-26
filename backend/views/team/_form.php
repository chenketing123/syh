<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
if(Yii::$app->request->get('type')){
    $model->type=Yii::$app->request->get('type');
}
/* @var $this yii\web\View */
/* @var $model backend\models\Team */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="team-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'type')->hiddenInput(['maxlength' => true])->label(false); ?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'book_id')->widget(Select2::classname(), [
        'data'=>\backend\models\Book::getList(),
        'options' => [
            'placeholder' => '请选择 ...',
            'multiple' => false,
        ],


    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '添加' : '保存', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
