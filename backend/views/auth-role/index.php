<?php
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '角色管理';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <p>
        <a class="btn btn-primary" href="<?= Url::to(['create'])?>">
            <i class="fa fa-plus"></i>
            新增角色
        </a>
    </p>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>角色</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>角色名称</th>
                            <th>创建时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($models as $model){ ?>
                            <tr>
                                <td><?= $model->name?></td>
                                <td><?= Yii::$app->formatter->asDatetime($model->created_at)?></td>
                                <td>
<!--                                    <a href="--><?//= Url::to(['accredit','parent'=>$model->name])?><!--"><span class="btn btn-info btn-sm">角色授权</span></a>&nbsp-->
                                    <a href="<?= Url::to(['auth-menu','name'=>$model->name])?>"><span class="btn btn-info btn-sm">菜单授权</span></a>&nbsp
                                    <a href="<?= Url::to(['edit','name'=>$model->name])?>"><span class="btn btn-info btn-sm">编辑</span></a>&nbsp
                                    <a href="<?= Url::to(['delete','name'=>$model->name])?>" onclick="deleted(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>&nbsp
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