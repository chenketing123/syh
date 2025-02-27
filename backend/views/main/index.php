<?php
use yii\helpers\Html;
use backend\widgets\MainLeftWidget;
use backend\assets\AppAsset;
use yii\helpers\Url;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<html>

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Yii::$app->params['siteTitle']?></title>
    <!--[if lt IE 8]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <link href="/Public/css/bootstrap.min.css?v=3.3.5" rel="stylesheet">
    <link href="/Public/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
    <link href="/Public/css/animate.min.css" rel="stylesheet">
    <link href="/Public/css/style.min.css?v=4.0.0" rel="stylesheet">
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<?php $this->beginBody() ?>
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        <span>
                            <?php if(Yii::$app->user->identity->head_portrait){ ?>
                                <img src="<?= Yii::$app->user->identity->head_portrait?>" class="img-circle" width="64px" height="64px">
                            <?php }else{ ?>
                                <img src="/Public/img/jianyan.jpg" class="img-circle">
                            <?php } ?>
                        </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                               <span class="block m-t-xs">
                                   <strong class="font-bold"><?= Yii::$app->user->identity->username?></strong>
                               </span>
                                <span class="text-muted text-xs block">
                                    <?php if(Yii::$app->user->identity->id === Yii::$app->params['adminAccount']){ ?>
                                        超级管理员
                                    <?php }else{ ?>
                                        <?php if($user->assignment['item_name']){ ?>
                                            <?= $user->assignment['item_name']?>
                                        <?php }else{ ?>
                                            未设置权限
                                        <?php } ?>
                                    <?php } ?>
                                    <b class="caret"></b>
                                </span>
                                </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li>
                                <a class="J_menuItem" href="<?= Yii::$app->urlManager->createUrl(['manager/personal'])?>">个人资料</a>
                            </li>
                            <li>
                                <a class="J_menuItem" href="<?= Yii::$app->urlManager->createUrl(['manager/up-passwd'])?>">修改密码</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="<?= Yii::$app->urlManager->createUrl('site/logout')?>" data-method="post">安全退出</a>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-element"><?php echo Yii::$app->user->identity->username;?>
                    </div>
                </li>
                <?= MainLeftWidget::widget() ?>
            </ul>
        </div>
    </nav>

    <!--左侧导航结束-->



    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top xjw_backend_top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                </div>
                <div class="xjw_backend_top_data">

                </div>
                <div class="xjw_backend_top_data_down" onclick="showAll()"><i class="fa fa-chevron-down"></i></div>
                <ul class="nav navbar-top-links navbar-right">
                    <!--
                    <li>
                        <span class="m-r-sm text-muted welcome-message">
                            <?=\Yii::t('app','语言选择')?>：

                            <a href="<?=Url::to(['language/language','language'=>'en-US'])?>">
                                <?php if(Yii::$app->language == 'en-US'){ ?>
                                    <font color="#ff0000"><?=Yii::t('app','英语')?></font>
                                <?php }else{?>
                                    <?=Yii::t('app','英语')?>
                                <?php }?>
                            </a>|
                            <a href="<?=Url::to(['language/language','language'=>'zh-CN'])?>">
                                <?php if(Yii::$app->language == 'zh-CN'){?>
                                    <font color="#ff0000"><?=Yii::t('app','中文')?></font>
                                <?php }else{?>
                                    <?=Yii::t('app','中文')?>
                                <?php }?>
                            </a>|
                        </span>
                    </li>--!>
                    <li class="dropdown hidden-xs">
                        <a class="right-sidebar-toggle" aria-expanded="false">
                            <i class="fa fa-tasks"></i> <?=Yii::t('app','主题')?>
                        </a>
                    </li>
                </ul>



            </nav>
        </div>
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="index_v1.html">首页</a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>

                </button>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabShowActive"><a>定位当前选项卡</a>
                    </li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a>关闭全部选项卡</a>
                    </li>
                    <li class="J_tabCloseOther"><a>关闭其他选项卡</a>
                    </li>
                </ul>
            </div>
            <a href="<?= Yii::$app->urlManager->createUrl('site/logout')?>"  class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="<?= Yii::$app->urlManager->createUrl('main/system')?>" frameborder="0" data-id="index_v1.html" seamless></iframe>
        </div>
        <div class="footer">
        </div>
    </div>
    <!--右侧部分结束-->
    <!--右侧边栏开始-->
    <div id="right-sidebar">
        <div class="sidebar-container">
            <div class="tab-content">
                <div id="tab-1" class="tab-pane active">
                    <div class="skin-setttings">
                        <div class="title">主题设置</div>
                        <div class="setings-item">
                            <span>收起左侧菜单</span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="collapsemenu" class="onoffswitch-checkbox" id="collapsemenu">
                                    <label class="onoffswitch-label" for="collapsemenu">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                            <span>固定顶部</span>

                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="fixednavbar" class="onoffswitch-checkbox" id="fixednavbar">
                                    <label class="onoffswitch-label" for="fixednavbar">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="setings-item">
                                <span>
                        固定宽度
                    </span>
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" name="boxedlayout" class="onoffswitch-checkbox" id="boxedlayout">
                                    <label class="onoffswitch-label" for="boxedlayout">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="title">皮肤选择</div>
                        <div class="setings-item default-skin nb">
                                <span class="skin-name ">
                         <a href="#" class="s-skin-0">
                             默认皮肤
                         </a>
                    </span>
                        </div>
                        <div class="setings-item blue-skin nb">
                                <span class="skin-name ">
                        <a href="#" class="s-skin-1">
                            蓝色主题
                        </a>
                    </span>
                        </div>
                        <div class="setings-item yellow-skin nb">
                                <span class="skin-name ">
                        <a href="#" class="s-skin-3">
                            黄色/紫色主题
                        </a>
                    </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--右侧边栏结束-->
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>



