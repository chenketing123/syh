<?php
/**
 * Created by PhpStorm.
 * User: JianYan
 * Date: 2016/4/11
 * Time: 14:24
 */
$this->title = '菜单显示';
$this->params['breadcrumbs'][] = ['label' => '后台管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    ins{
        display: none !important;
    }
</style>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>菜单列表</h5>
                </div>
                <div class="ibox-content">
                    <form class="form-horizontal" method="post" action="">
                        <div class="form-group">
                            <div class="col-sm-10">
                                <?php foreach($menu as $item){ ?>
                                    <div class="checkbox i-checks">
                                        <label class="checkbox-inline i-checks" onclick="checkThis(this)">
                                            <div class="icheckbox_square-green" style="position: relative;">
                                                <input type="checkbox" value="<?= $item['menu_id']?>" name="menu[]" <?php if(!empty($item['menuChild'])){ ?>checked="checked"<?php } ?>>
                                            </div><b><?= $item['title']?></b>
                                        </label>
                                    </div>
                                    <?php if(!empty($item['-'])){ ?>
                                        <?= $this->render('auth_menu_tree', [
                                            'models'=>$item['-'],
                                        ])?>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- 加入csrf验证-->
                        <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                        <input name="name" type="hidden"  value="<?= $name ?>">

                        <div class="hr-line-dashed"></div>
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button type="submit" class="btn btn-primary">保存内容</button>
                                <span class="btn btn-white" onclick="history.go(-1)">返回</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function checkThis(_this){
        setTimeout(function(){
            if($(_this).children(".icheckbox_square-green").children(".icheckbox_square-green").hasClass("checked")){
                $(_this).children(".icheckbox_square-green").children(".icheckbox_square-green").children("input[type=checkbox]").prop("checked","checked");
                $(_this).parent().next(".checkbox-inline").children(".i-checks").children(".icheckbox_square-green").children(".icheckbox_square-green").addClass("checked");
                $(_this).parent().next(".checkbox-inline").children(".i-checks").children(".icheckbox_square-green").children(".icheckbox_square-green").children("input[type=checkbox]").prop("checked","checked");
            }else{
                $(_this).children(".icheckbox_square-green").children(".icheckbox_square-green").children("input[type=checkbox]").removeAttr("checked");
                $(_this).parent().next(".checkbox-inline").children(".i-checks").children(".icheckbox_square-green").children(".icheckbox_square-green").removeClass("checked")
                $(_this).parent().next(".checkbox-inline").children(".i-checks").children(".icheckbox_square-green").children(".icheckbox_square-green").children("input[type=checkbox]").removeAttr("checked");
            }
        },10)
    }
</script>
</body>