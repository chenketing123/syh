<?php
use yii\widgets\ActiveForm;
use dosamigos\datepicker\DatePicker;
use backend\models\Provinces;

$this->params['breadcrumbs'][] = ['label' => '用户信息'];
?>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>基本信息</h5>
                </div>
                <div class="ibox-content">
                    <?= $form->field($model, 'head_portrait')->widget('backend\widgets\webuploader\Image', [
                        'boxId' => 'img',
                        'options' => [
                            'multiple'   => false,
                        ]
                    ])?>

                    <?= $form->field($model, 'realname')->textInput() ?>
                    <?= $form->field($model, 'mobile_phone')->textInput() ?>
                    <?= $form->field($model, 'email')->textInput() ?>
                    <?= $form->field($model, 'sex')->radioList(['1'=>'男','2'=>'女']) ?>
                </div>
                <div class="hr-line-dashed"></div>
                <div class="form-group">
                    <div class="col-sm-4 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit">保存内容</button>
                        <span class="btn btn-white" onclick="history.go(-1)">返回</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
</body>








