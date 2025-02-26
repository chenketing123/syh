<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\widgets\Bar;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $searchModel backend\search\TeamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Teams';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>读书设置</h5>
            </div>

            <div class="ibox-content">
                <form method="get" action="<?= \yii\helpers\Url::to(['team/task3'])?>">

                    <input type="hidden" name="id" value="<?= Yii::$app->request->get('id')?>">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>开始时间</td>
                            <td>
                                <?php $time= date('Y-m-d',$models[0]['time']); echo  \kartik\datetime\DateTimePicker::widget([
                                    'name' => "start_time",
                                    'value' => "$time",
                                    'pluginOptions' => [
                                        'format' => 'yyyy-mm-dd',
                                        'todayHighlight' => true,
                                        'minView' => 'month',
                                    ]]);?>
                            </td>
                            <td>   <button type="submit" class="btn btn-primary">保存</button></td>


                        </tr>

                        </tbody>
                    </table>



                </form>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>名称</th>
                        <th>章节</th>
                        <th>读书日期</th>
                    </tr>
                    </thead>
                    <form method="get" action="<?= \yii\helpers\Url::to(['team/book'])?>">
                    <tbody>
                    <?php foreach($models as $k=>$v){ if($v['detail']['number2']>0){ $title='第'.$v['detail']['number2'].'节';}else{ $title='';} ?>
                        <tr>
                            <td><?= $k+1?></td>
                            <td><?= $v['book']['title']?></td>
                            <td><?= '第'.$v['detail']['number1'].'章'. $title.$v['detail']['title']?></td>
                            <td><?php $time= date('Y-m-d',$v['time']); echo  \kartik\datetime\DateTimePicker::widget([
                                    'name' => "book[" . $v['id'] . "]",
                                    'value' => "$time",
                                    'pluginOptions' => [
                                        'format' => 'yyyy-mm-dd',
                                        'todayHighlight' => true,
                                        'minView' => 'month',
                                    ]]);?>


                               </td>
                        </tr>
                    <?php } ?>
                    <button type="submit" class="btn btn-primary">保存</button>
                    </tbody>


                    </form>
                </table>
            </div>
        </div>
    </div>
</div>

