<?php
use yii\helpers\Url;
use \kucha\ueditor\UEditor;
use backend\models\Config;

$this->title = '系统配置';
$this->params['breadcrumbs'][] = ['label' =>  $this->title];
?>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <?php $rank = 1?>
                    <?php foreach ($configGroupList as $group){ ?>
                        <li <?php if($rank == 1){ ?>class="active"<?php } ?>>
                            <a aria-expanded="false" href="#tab-<?= $group['id']?>" data-toggle="tab"> <?= $group['title']?></a>
                        </li>
                        <?php $rank++ ?>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <?php $rank = 1?>
                    <?php foreach ($configGroupList as $group){ ?>
                        <div class="tab-pane <?php if($rank == 1){ ?>active<?php } ?>" id="tab-<?= $group['id']?>">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <form class="form-horizontal" method="post" action="" id="form-tab-<?= $group['id']?>">
                                            <div class="ibox float-e-margins">
                                                <div class="ibox-content">
                                                    <?php if($group['list']){ ?>
                                                        <?php foreach ($group['list'] as $row){ ?>
                                                            <?php if($row['type'] == 1){ ?>
                                                                <div class="form-group">
                                                                    <label class="control-label"><?= $row['title']?></label>　(<?= $row['remark']?>)
                                                                    <input type="text" value="<?= $row['value']?>" name="config[<?= $row['name']?>]" class="form-control">
                                                                </div>
                                                            <?php }elseif($row['type'] == 2){ ?>
                                                                <div class="form-group">
                                                                    <label class="control-label"><?= $row['title']?></label>　(<?= $row['remark']?>)
                                                                    <input type="password" value="<?= $row['value']?>" name="config[<?= $row['name']?>]" class="form-control">
                                                                </div>
                                                            <?php }elseif($row['type'] == 3){ ?>
                                                                <div class="form-group">
                                                                    <label class="control-label"><?= $row['title']?></label>　(<?= $row['remark']?>)
                                                                    <textarea name="config[<?= $row['name']?>]" class="form-control"><?= $row['value']?></textarea>
                                                                </div>
                                                            <?php }elseif($row['type'] == 4){
                                                                //获取数组
                                                                $option = Config::parseConfigAttr($row['extra']);
                                                                ?>
                                                                <div class="form-group">
                                                                    <label  class="control-label"><?= $row['title']?></label>　(<?= $row['remark']?>)
                                                                    <select name="config[<?= $row['name']?>]" class="form-control">
                                                                        <?php foreach ($option as $key => $v){ ?>
                                                                            <option value="<?= $key?>" <?php if($key == $row['value']){ ?>selected="selected"<?php } ?>><?= $v?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            <?php }elseif($row['type'] == 5){
                                                                //获取数组
                                                                $option = Config::parseConfigAttr($row['extra']);
                                                                ?>
                                                                <div class="form-group">
                                                                    <label class="control-label"><?= $row['title']?></label>　(<?= $row['remark']?>)
                                                                    <div class="col-sm-push-10">
                                                                        <?php foreach ($option as $key => $v){ ?>
                                                                            <label class="radio-inline">
                                                                                <input type="radio" name="config[<?= $row['name']?>]" class="radio" value="<?= $key?>" <?php if($key == $row['value']){ ?>checked<?php } ?>><?= $v?>
                                                                            </label>
                                                                        <?php } ?>
                                                                    </div>
                                                                </div>
                                                            <?php }elseif($row['type'] == 6){ ?>
                                                                <div class="form-group">
                                                                    <label class="control-label"><?= $row['title']?></label>　(<?= $row['remark']?>)
                                                                    <?= UEditor::widget([
                                                                        'id' => "config[".$row['name']."]",
                                                                        'attribute' => $row['name'],
                                                                        'name' => $row['name'],
                                                                        'value' => $row['value'],
                                                                        'clientOptions' => [
                                                                            //编辑区域大小
                                                                            'initialFrameHeight' => '200',
                                                                        ],
                                                                    ]);?>
                                                                </div>
                                                            <?php }elseif($row['type'] == 7){ ?>
                                                                <div class="form-group">
                                                                    <label class="control-label"><?= $row['title']?></label>　(<?= $row['remark']?>)
                                                                    <div class="col-sm-push-10">
                                                                        <?= backend\widgets\webuploader\Image::widget([
                                                                            'boxId' => $row['name'],
                                                                            'name'  =>"config[".$row['name']."]",
                                                                            'value' => $row['value'],
                                                                            'id'            =>$row['id'],
                                                                            'options'=>[
                                                                                'multiple'      => false,
                                                                            ]
                                                                        ])?>
                                                                    </div>
                                                                </div>
                                                            <?php }elseif($row['type'] == 8){ ?>
                                                                <div class="form-group">
                                                                    <label class="control-label"><?= $row['title']?></label>　(<?= $row['remark']?>)
                                                                    <div class="col-sm-push-10">
                                                                        <?= backend\widgets\webuploader\Videos::widget([
                                                                            'boxId' => $row['name'],
                                                                            'name'  =>"config[".$row['name']."]",
                                                                            'value' => $row['value'],
                                                                            'id'            =>$row['id'],
                                                                            'options'=>[
                                                                                'multiple'      => false,
                                                                            ]
                                                                        ])?>
                                                                    </div>
                                                                </div>
                                                            <?php }elseif($row['type'] == 9){ ?>
                                                                <div class="form-group">
                                                                    <label class="control-label"><?= $row['title']?></label>　(<?= $row['remark']?>)
                                                                    <div class="col-sm-push-10">
                                                                        <?= backend\widgets\webuploader\Audios::widget([
                                                                            'boxId' => $row['name'],
                                                                            'name'  =>"config[".$row['name']."]",
                                                                            'value' => $row['value'],
                                                                            'id'            =>$row['id'],
                                                                            'options'=>[
                                                                                'multiple'      => false,
                                                                            ]
                                                                        ])?>
                                                                    </div>
                                                                </div>
                                                            <?php }elseif($row['type'] == 10){ ?>
                                                                <div class="form-group">
                                                                    <label class="control-label"><?= $row['title']?></label>　(<?= $row['remark']?>)
                                                                    <div class="col-sm-push-10">
                                                                        <?= backend\widgets\webuploader\Files::widget([
                                                                            'boxId' => $row['name'],
                                                                            'name'  =>"config[".$row['name']."]",
                                                                            'value' => $row['value'],
                                                                            'id'            =>$row['id'],
                                                                            'options'=>[
                                                                                'multiple'      => false,
                                                                            ]
                                                                        ])?>
                                                                    </div>
                                                                </div>
                                                            <?php }
                                                        }
                                                    } ?>
                                                </div>
                                                <div class="hr-line-dashed"></div>
                                                <input name="_csrf" type="hidden" id="_csrf" value="<?= Yii::$app->request->csrfToken ?>">
                                                <div class="form-group">
                                                    <div class="col-sm-4 col-sm-offset-2">
                                                        <span type="submit" class="btn btn-primary" onclick="present(<?= $group['id']?>)">保存内容</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php $rank++ ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">

    function present(obj){

        //获取表单内信息
        var values = $("#form-tab-"+obj).serialize();

        $.ajax({
            type:"post",
            url:"<?= Url::to(['update-info'])?>",
            dataType: "json",
            data: values,
            success: function(data){
                if(data.flg == 2) {
                    alert(data.msg);
                }else{
                    alert('保存成功');
                }
            }
        });
    }
</script>
