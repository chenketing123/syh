<?php
/**
 * Created by PhpStorm.
 * User: JianYan
 * Date: 2016/4/11
 * Time: 14:24
 */
use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = '管理员';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>查询</h5>
                </div>
                <div class="ibox-content">
                    <form action="" method="get" class="form-horizontal" role="form" id="form">
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 control-label">搜索类型</label>
                            <div class="col-sm-8 col-lg-9 col-xs-12">
                                <div class="btn-group">
                                    <a href="<?= Url::to(['index','type'=>1])?>" class="btn <?php if($type == 1){ ?>btn-primary<?php }else{ ?>btn-white<?php } ?>">登陆账号</a>
                                    <a href="<?= Url::to(['index','type'=>2])?>" class="btn <?php if($type == 2){ ?>btn-primary<?php }else{ ?>btn-white<?php } ?>">真实姓名</a>
                                    <a href="<?= Url::to(['index','type'=>3])?>" class="btn <?php if($type == 3){ ?>btn-primary<?php }else{ ?>btn-white<?php } ?>">手机号码</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-xs-12 col-sm-2 col-md-2 control-label">关键字</label>
                            <div class="col-sm-8 col-xs-12">
                                <input type="hidden" class="form-control" name="type" value="<?= $type?>" />
                                <input type="text" class="form-control" name="keyword" value="<?= $keyword?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="pull-right col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                <button class="btn btn-white"><i class="fa fa-search"></i> 搜索</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <p>
        <a class="btn btn-primary" href="<?= Url::to(['edit'])?>">
            <i class="fa fa-plus"></i>
            新增用户
        </a>
    </p>
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>用户</h5>
                </div>
                <div class="ibox-content">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>头像</th>
                            <th>授权角色</th>
                            <th>登录账号</th>
                            <th>姓名</th>
                            <th>手机号码</th>
                            <th>邮箱</th>
                            <th>访问次数</th>
                            <th>最后登陆IP</th>
                            <th>最后登陆时间</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($models as $k=>$model){ ?>
                            <tr>
                                <td><?= $k+1+($pages->pageSize)*($pages->page)?></td>
                                <td class="feed-element">
                                    <?php if($model->head_portrait){ ?>
                                        <img src="<?= $model->head_portrait?>" class="img-circle">
                                    <?php }else{ ?>
                                        <img src="/Public/img/default-head.png" class="img-circle">
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if($model->id === Yii::$app->params['adminAccount']){ ?>
                                        <span class="badge badge-info">超级管理员</span>
                                    <?php }else{ ?>
                                        <?php if($model->assignment['item_name']){ ?>
                                            <span class="badge badge-info"><?= $model->assignment['item_name']?></span>
                                        <?php }else{ ?>
                                            <span class="badge">未设置身份</span>
                                        <?php } ?>
                                    <?php } ?>
                                </td>
                                <td><?= $model->username?></td>
                                <td><?= $model->realname?></td>
                                <td><?= $model->mobile_phone?></td>
                                <td><?= $model->email?></td>
                                <td><?= $model->visit_count?></td>
                                <td><?= $model->last_ip?></td>
                                <td><?= Yii::$app->formatter->asDatetime($model->last_time)?></td>
                                <td>
                                    <a href="<?= Url::to(['edit-personal','id'=>$model->id])?>"><span class="btn btn-info btn-sm">用户信息</span></a>&nbsp
                                    <a href="<?= Url::to(['edit','id'=>$model->id])?>"><span class="btn btn-info btn-sm">账号管理</span></a>&nbsp
                                    <?php if($model->id != Yii::$app->params['adminAccount']){ ?>
                                        <a href="<?= Url::to(['auth-role','user_id'=>$model->id])?>"><span class="btn btn-info btn-sm">授权角色</span></a>&nbsp
                                        <a href="<?= Url::to(['delete','id'=>$model->id])?>"  onclick="deleted(this);return false;"><span class="btn btn-warning btn-sm">删除</span></a>&nbsp
                                    <?php } ?>
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
