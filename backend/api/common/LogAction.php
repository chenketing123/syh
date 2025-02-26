<?php

namespace backend\api\common;
use common\base\api\CommonApiAction;

use Yii;

/**
 * Class UpImageAction
 * @package backend\api\common
 * User:五更的猫
 * DateTime:2020/9/15 11:42
 * TODO 上传图片
 */
class LogAction extends CommonApiAction
{

    public $isSign = false;
    public $isLogin = false;
    protected function runAction()
    {


        $jsonData['type']=1;
        $jsonData['errmsg']='';
        return $jsonData;


    }

}