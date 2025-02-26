<?php
namespace backend\api\common;

use backend\models\About;
use backend\models\Codes;
use backend\models\User;
use common\base\api\ApiAction;
use common\components\CommonFunction;
use common\exception\ApiException;
use Yii;

/**
 * Class PhoneCodeAction
 * @package backend\api\common
 * User:五更的猫
 * DateTime:2020/8/25 14:36
 * TODO 发送手机验证码
 */
class PhoneCodeAction extends ApiAction
{
    protected function runAction()
    {
        $phone = trim($this->RequestData('phone', ''));
        $action = $this->RequestData('action', '');

        if (empty($phone) || !preg_match('/^[1][0-9]{10}$/', $phone)) {

            throw new ApiException('发送失败',1);
        }
        $is_login = User::find()->where(['or',['phone1'=>$phone],['phone2'=>$phone]])->exists();

        if($action=='login'){
            if(!$is_login){
                throw new ApiException('此手机号未关联账号',1);
            }
        }
        if($action=='register'){
            if($is_login){
                throw new ApiException('此手机号已关联账号',1);
            }
        }

        $jsonData = Codes::addCode($phone);

        if($jsonData['errcode']!=0){
            throw new ApiException($jsonData['errmsg'],1);
        }

        $jsonData['is_login'] = $is_login?1:2;

        return $jsonData;
    }

}