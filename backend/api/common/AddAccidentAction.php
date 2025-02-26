<?php

namespace backend\api\common;
use backend\models\Accident;
use common\base\api\ApiAction;
use common\exception\ApiException;
use Yii;

/**
 * Class UpImageAction
 * @package backend\api\common
 * User:五更的猫
 * DateTime:2020/9/15 11:42
 * TODO 上传图片
 */
class AddAccidentAction extends ApiAction
{

    public $isSign = true;
    public $isLogin = true;
    protected function runAction()
    {

        $post=$this->RequestData();
        $new=new Accident();
        $new->setAttributes($post);
        $new->user_id=$this->user['id'];
        if(!$new->save()){
            $errors=$new->getFirstErrors();
            throw new ApiException(reset($errors), 1);
        }
        $jsonData['errmsg']='';


        return $jsonData;
    }

}