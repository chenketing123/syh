<div class="checkbox checkbox-inline">
    <?php foreach($models as $item){ ?>
        <label class="checkbox-inline i-checks" onclick="clickThisTwo(this)">
            <div class="icheckbox_square-green" style="position: relative;">
                <input type="checkbox" value="<?= $item['menu_id']?>" name="menu[]" <?php if(!empty($item['menuChild'])){?>checked="checked"<?php } ?>>
            </div><?= $item['title']?>
        </label>
        <?php if(!empty($model['-'])){ ?>
            <?= $this->render('auth_menu_tree', [
                'models'=>$item['-'],
            ]) ?>
        <?php } ?>
    <?php } ?>
</div>


<script>
    function clickThisTwo(_this){
        setTimeout(function(){
            if($(_this).children(".icheckbox_square-green").children(".icheckbox_square-green").hasClass("checked")){
                $(_this).parent().prev(".i-checks").children(".i-checks").children(".icheckbox_square-green").children(".icheckbox_square-green").addClass("checked");
                $(_this).parent().prev(".i-checks").children(".i-checks").children(".icheckbox_square-green").children(".icheckbox_square-green").children("input[type=checkbox]").prop("checked","checked");
                $(_this).children(".icheckbox_square-green").children(".icheckbox_square-green").children("input[type=checkbox]").prop("checked","checked");
            }
        },10)
    }
</script>


