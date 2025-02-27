<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;
use backend\models\ActionLog;

$this->title = '日志管理';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>日志</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>操作用户</th>
                            <th>model</th>
                            <th>类型</th>
                            <th>URL</th>
                            <th>操作时间</th>
                            <th>IP地址</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($models as $model){ ?>
                            <tr id = <?= $model->id?>>
                                <td><?= $model->id?></td>
                                <td><?= $model->manager['username']?></td>
                                <td><?= $model->model?></td>
                                <td><?= ActionLog::remarkBehavior($model->action_id)?></td>
                                <td><?= urldecode($model->log_url)?></td>
                                <td><?= Yii::$app->formatter->asDatetime($model->append)?></td>
                                <td><?= long2ip($model->action_ip)?></td>
                                <td>
                                    <a href="<?= Url::to(['delete','id'=>$model->id])?>" onclick="deleted(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-sm-12">
                            <?= LinkPager::widget([
                                'pagination'        => $pages,
                                'maxButtonCount'    => 5,
                                'firstPageLabel'    => "首页",
                                'lastPageLabel'     => "尾页",
                                'nextPageLabel'     => "下一页",
                                'prevPageLabel'     => "上一页",
                            ]);?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>