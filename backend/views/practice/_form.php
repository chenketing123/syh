<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
if(is_numeric($model->start_time)){
    if($model->start_time==0){
        $model->start_time=date('Y-m-d');
    }else{
        $model->start_time=date('Y-m-d',$model->start_time);
    }
}

if(is_numeric($model->end_time)){
    if($model->end_time==0){
        $model->end_time=date('Y-m-d');
    }else{
        $model->end_time=date('Y-m-d',$model->end_time);
    }
}
/* @var $this yii\web\View */
/* @var $model backend\models\Practice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="practice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'category_id')->widget(\johnnylei\jstree\ActiveFormJsTree::className(), [
        'options' => [
            'core' => [
                'data' => [
                    "url" => Url::to(['practice-category/category-tree']),
                    'dataType' => 'json',
                ],
            ],

        ],

    ]) ?>


    <?= $form->field($model, 'start_time', ['options' => ['tag' => false]])->widget(
        \kartik\datetime\DateTimePicker::class, [
            'pluginOptions' => [
                'language' => 'zh-CN',
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
                'minView' => 'month',
            ]]
    )?>

    <?= $form->field($model, 'end_time', ['options' => ['tag' => false]])->widget(
        \kartik\datetime\DateTimePicker::class, [
            'pluginOptions' => [
                'language' => 'zh-CN',
                'format' => 'yyyy-mm-dd',
                'autoclose' => true,
                'minView' => 'month',
            ]]
    )?>

    <?= $form->field($model, 'image')->widget('backend\widgets\webuploader\Image', [
        'boxId' => 'image',
        'options' => [
            'multiple' => false,
        ]
    ]) ?>




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


<script>
    function goods_category(id){

        $.ajax({
            "url":"<?= Url::to(['ajax/category'])?>",
            "dataType" : "json",
            "type" : 'get',
            "data":{"id":id,'goods_id':"<?= $model->id?>"},
            "success" : function (data) {
                $('#category_search').html(data);

            },


        });
    }
</script>
