<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\widgets\Bar;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $searchModel backend\search\ActivityUserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Activity Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">

                <?php echo $this->render('_search2', ['model' => $searchModel]); ?>
                <?= GridView::widget([
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

                        'order_number',
                        [
                            'attribute' => 'user_id',
                            'value' => function($data){
                                return $data->user['name'];
                            }
                        ],
                        [
                            'attribute' => 'activity_id',
                            'value' => function($data){
                                return $data->activity['title'];
                            }
                        ],


                        [
                            'attribute' => 'mobile',
                            'class' => 'kartik\grid\EditableColumn'
                        ],
                        [
                            'attribute' => 'name',
                            'class' => 'kartik\grid\EditableColumn'
                        ],
                        [
                            'attribute' => 'pay_status',
                            'value' => function($data){
                                return \backend\models\ActivityUser::$status_message[$data->status];
                            }
                        ],
                        'created_at:datetime',
                        [
                            'attribute' => 'check_time',
                            'value' => function($data){
                                if($data->check_time>0){
                                    return date('Y-m-d H:i:s',$data->check_time);
                                }
                            }
                        ],

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

