<?php

use common\components\CommonFunction;
use yii\helpers\Html;
use kartik\grid\GridView;
use backend\widgets\Bar;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $searchModel backend\search\UserCheckSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User Checks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-content">

                <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                <?= Bar::widget(['template'=>'{delete}']) ?>
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


                        [
                            'attribute' => 'user_id',
                            'value' =>function($data){
                                return $data->user['name'];
                            }
                        ],


                        [
                            'attribute' => 'user_id',
                            'label'=>'手机号',
                            'value' =>function($data){
                                return $data->user['mobile_phone'];
                            }
                        ],
                        [
                            'attribute' => 'book_id',
                            'value' =>function($data){
                                return $data->book['title'];
                            }
                        ],
                        [
                            'attribute' => 'detail_id',
                            'value' =>function($data){
                                if($data->detail['number2']>0){
                                    return $data->detail['number1'].'章'. $data->detail['number2'].'节';
                                }else{
                                    return $data->detail['number1'].'章';
                                }

                            }
                        ],
                        'time:date',

                        [
                            'attribute' => 'status',
                            'value' => function($data){
                                return \backend\models\UserCheck::$status_message[$data->status];
                            }
                        ],
                        [
                            'attribute' => 'relation_id',
                            'value' =>function($data){
                                return $data->team['title'];
                            }
                        ],
                        [
                            'attribute' => 'file',
                            'format' => 'html',
                            'value' => function ($data) {
                                if ($data->file) {
                                    return CommonFunction::setImg($data->file);;
                                }
                            }
                        ],
                        'content',
                        [
                            'attribute' => 'image',
                            'format' => 'html',
                            'value' => function ($data) {
                                if ($data->image) {
                                    return "<img class='show_image' style='width: 100px;height: 100px' src='$data->image'>";
                                }
                            }
                        ],

                        [
                            'attribute' => 'check_time',
                            'value' => function($data){
                                if($data->check_time>0){
                                    return date('Y-m-d H:i:s',$data->check_time);
                                }
                            }
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

