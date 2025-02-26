<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
if(Yii::$app->request->get('book_id')){
    $model->book_id=Yii::$app->request->get('book_id');
}

/* @var $this yii\web\View */
/* @var $model backend\models\BookDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-detail-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'book_id')->textInput(['maxlength' => true])->hiddenInput()->label(false) ?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'number1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'number2')->textInput(['maxlength' => true]) ?>
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
