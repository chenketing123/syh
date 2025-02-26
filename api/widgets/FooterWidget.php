<?php
/**
 * Created by PhpStorm.
 * User: zjb05
 * Date: 2017/4/27
 * Time: 11:51
 */

namespace frontend\widgets;


use backend\models\Article;
use backend\models\DeskMenu;
use yii\base\Widget;

class FooterWidget extends Widget
{
    public function run()
    {

        //print_r($rootpage);
        return $this->render('footer/footer');
    }

}