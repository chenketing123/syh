<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\widgets\Bar;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $searchModel backend\search\questionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Questions';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">

                <?php echo $this->render('_search', ['model' => $searchModel]); ?>

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
                            'attribute' => 'user_id',
                            'value' => function ($data) {
                                return $data->user['name'];
                            }
                        ],
                        [
                            'attribute' => 'hit',
                            'class' => 'kartik\grid\EditableColumn'
                        ],
                        [
                            'attribute' => 'answer',
                            'class' => 'kartik\grid\EditableColumn'
                        ],
                        [
                            'attribute' => 'category_id',
                            'value' => function ($data) {
                                return $data->category['title'];
                            }
                        ],

                        [
                            'attribute' => 'status',
                            'value' => function ($data) {
                                return \backend\models\Question::$status_message[$data->status];
                            }
                        ],
                        [
                            'attribute' => 'content',
                            'class' => 'kartik\grid\EditableColumn'
                        ],

                        ['class' => 'yii\grid\ActionColumn', 'template' => '{true} {false} {update} {delete}',
                            'buttons' => [

                                'true' => function ($url, $model, $key) {

                                    if ($model->status == 1) {
                                        return "<a   type=\"button\" class=\"btn   btn-primary btn-sm\"  href=\"$url\" data-method='post' data-pjax='0' data-confirm='确定要通过吗？'> 审核通过</a>";

                                    }

                                },


                                'false' => function ($url, $model, $key) {

                                    if ($model->status == 1) {
                                        return "<a   type=\"button\" class=\"btn btn-warning btn-sm\"  href=\"$url\" data-method='post' data-pjax='0' data-confirm='确定要不通过吗？'> 审核不通过</a>";

                                    }
                                },


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

