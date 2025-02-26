<?php

namespace backend\api\common;

use backend\models\User;
use common\base\api\ApiAction;
use common\components\Weixin;
use common\components\WxApi;
use common\exception\ApiException;
use Yii;
use yii\base\BaseObject;


class LoginAction extends ApiAction
{


//    public $isSign = true;

    protected function runAction()
    {

        $code=$this->RequestData('code');
        $code2=$this->RequestData('code2');
        if(!$code){
            throw new ApiException('code不能为空', 1);
        }
        $token=Weixin::Token();
        $url="https://api.weixin.qq.com/wxa/business/getuserphonenumber?access_token=$token";
        $param=[
            'code'=>$code
        ];
        $re=WxApi::curl($param,$url);
        $message=json_decode($re,true);
        if($message['errcode']==0){
            $mobile = $message['phone_info']['phoneNumber'];
        }else{
            throw new ApiException($message['errmsg'], 1);
        }
        if(!$mobile){
            throw new ApiException('获取手机号失败2', 1);
        }
        $model = User::find()->where(['mobile_phone' => $mobile])->limit(1)->one();
        if (!$model) {
            if($code2){

            }
            $new = new User();
            $new->mobile_phone = $mobile;
            $new->save();
            $jsonData['token'] = $new->getToken();
            $jsonData['id'] = $new->id;
            $jsonData['name'] = $new->name;
            $jsonData['head_image'] = Yii::getAlias('@index').'/images/touxiang.png';
            $jsonData['is_new'] = 1;
        } else {
            $jsonData['token'] = $model->getToken();
            $jsonData['id'] = $model->id;
            $jsonData['name'] = $model->name;
            $jsonData['head_image'] = $model->getImg();
            $jsonData['is_new'] = 0;
        }


        $jsonData['errmsg'] = '';
        return $jsonData;
    }


}