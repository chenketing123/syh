<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\widgets\Bar;
use kartik\switchinput\SwitchInput;

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


                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'export' => false,
                    'options' => ['class' => 'grid-view', 'style' => 'overflow:auto', 'id' => 'grid'],
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],


                        'name',
                        'mobile',


                        [
                            'attribute' => 'parent_id',
                            'value' => function ($data) {
                                if($data->parent_id>0){
                                    return \backend\models\User::name($data->parent_id);
                                }

                            }

                        ],
                        'add_number',
                        [
                            'attribute' => 'type',
                            'value' => function ($data) {
                                return \backend\models\User::$type_message[$data->type];

                            }

                        ],

                        [
                            'attribute' => 'head_image',
                            'format' => 'html',
                            'value' => function ($data) {
                                if ($data->head_image) {
                                    return "<img class='show_image' style='width: 100px;height: 100px' src='$data->head_image'>";
                                }
                            }
                        ],
                        'created_at:datetime',

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

