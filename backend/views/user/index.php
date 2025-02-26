<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\widgets\Bar;
use kartik\switchinput\SwitchInput;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">

                <?php echo $this->render('_search', ['model' => $searchModel]); ?>

                <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['daoru']),]); ?>

                <?= $form->field($add, 'file')->fileInput(['multiple' => true])->label('导入') ?>

                <a class="btn btn-primary" href="/attachment/muban.xlsx">模板下载</a>

                <button class="btn btn-primary">导入</button>
                <?php ActiveForm::end()?>

                <?= Bar::widget() ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'export' => false,
                    'options' => ['class' => 'grid-view', 'style' => 'overflow:auto', 'id' => 'grid'],
                    'columns' => [
                        [
                            'headerOptions' => ['width' => '20'],
                            'class' => 'yii\grid\CheckboxColumn',
                            'name' => 'id',
                        ],
                        ['class' => 'yii\grid\SerialColumn'],

                        'name',
                        'mobile_phone',
                        'company',
                        'sex_value',
//                        [
//                                'attribute'=>'sex',
//                                'value'=>function($data){
//                                    if($data->sex==1){
//                                        return '男';
//                                    }elseif ($data->sex==2){
//                                        return  '女';
//                                    }else{
//                                        return '';
//                                    }
//                                }
//                        ],

                        [
                            'attribute'=>'is_vip',
                            'value'=>function($data){
                                if($data->is_vip==1){
                                    return '是';
                                }else{
                                    return '否';
                                }
                            }
                        ],
                        'created_at:datetime',


                        ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',
                            'buttons' => [
                                'update' => function ($url, $model, $key) {
                                    return "<a href='javascript:void(0);'  type=\"button\" class=\"btn btn-primary btn-sm\"  onclick=\"viewLayer('$url',$(this))\" data-pjax='0' > 编辑</a>";

                                },
                                'delete' => function ($url, $model, $key) {
                                    return "<a   type=\"button\" class=\"btn btn-warning btn-sm\"  href=\"$url\" data-method='post' data-pjax='0' data-confirm='确定要删除吗？'> 删除</a>";

                                },
                            ]


                        ],
                    ],
                    'pager' => [
                        'class' => \common\components\GoPager::className(),
                        'firstPageLabel' => '首页',
                        'prevPageLabel' => '《',
                        'nextPageLabel' => '》',
                        'lastPageLabel' => '尾页',
                        'goPageLabel' => true,
                        'totalPageLable' => '共x页',
                        'goButtonLable' => 'GO',
                        'maxButtonCount' => 5
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>

