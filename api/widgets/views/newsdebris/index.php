<?php
/**
 * Created by PhpStorm.
 * User: zjb05
 * Date: 2017/5/31
 * Time: 12:02
 */
use yii\helpers\Url;
use common\components\Helper;
?>
<?php

foreach($models as $k => $v){
    ?>
    <li><a href="<?php echo Url::to(['/xczx/detail','id'=>$v->article_id]);?>" class="m_width365 m_font_size16 m_hover2"><?php echo Helper::truncate_utf8_string($v->title,25);?></a></li>
    <?php
	}
?>
