<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use backend\widgets\Bar;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <div class="mail-tools tooltip-demo m-t-md">
                    <a class="btn btn-white btn-sm" href="javascript:void(0);" title="添加" data-pjax="0"
                       onclick="viewLayer('/backend/index.php/user-team/create.html?team_id=<?= $id?>',$(this))"><i class="fa fa-plus"></i> 添加
                    </a>

                </div>

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


                        'id',
                        [
                                'attribute'=>'user_id',
                                'value'=>function($data){
                                    return $data['user']['name'];
                                }
                        ],


                        ['class' => 'yii\grid\ActionColumn', 'template' => '{delete} ',
                            'buttons' => [
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

