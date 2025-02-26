<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\widgets\Bar;
use kartik\switchinput\SwitchInput;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel backend\search\HistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Histories';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">

                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                <?php $form = ActiveForm::begin(['action' => \yii\helpers\Url::to(['daoru']),]); ?>

                <?= $form->field($add, 'file')->fileInput(['multiple' => true])->label('导入') ?>


                <a class="btn btn-primary" href="/attachment/传感器数据模板.xls">模板下载</a>

                <button class="btn btn-primary"><i class="fa fa-plus"></i>导入</button>

                <?php ActiveForm::end(); ?>
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


                        [
                            'attribute' => 'code',
                            'class' => 'kartik\grid\EditableColumn'
                        ],
                        [
                            'attribute' => 'name',
                            'class' => 'kartik\grid\EditableColumn'
                        ],
                        [
                            'attribute' => 'lng',
                            'class' => 'kartik\grid\EditableColumn'
                        ],
                        [
                            'attribute' => 'lat',
                            'class' => 'kartik\grid\EditableColumn'
                        ],
                        [
                            'attribute' => 'number1',
                            'class' => 'kartik\grid\EditableColumn'
                        ],
                        [
                            'attribute' => 'number2',
                            'class' => 'kartik\grid\EditableColumn'
                        ],
                        [
                            'attribute' => 'number3',
                            'class' => 'kartik\grid\EditableColumn'
                        ],
                        [
                            'attribute' => 'number4',
                            'class' => 'kartik\grid\EditableColumn'
                        ],
                        [
                            'attribute' => 'number5',
                            'class' => 'kartik\grid\EditableColumn'
                        ],
                        [
                            'attribute' => 'number6',
                            'class' => 'kartik\grid\EditableColumn'
                        ],
                        [
                            'attribute' => 'number7',
                            'class' => 'kartik\grid\EditableColumn'
                        ],
                        'time:datetime',
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

