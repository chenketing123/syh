<?php

namespace backend\api\common;

use backend\models\User;
use common\base\api\ApiAction;
use common\components\Weixin;
use common\components\WxApi;
use common\exception\ApiException;
use Yii;
use yii\base\BaseObject;


class OpenidAction extends ApiAction
{


    public $isSign = true;
    public $isLogin=true;

    protected function runAction()
    {

        $code=$this->RequestData('code');
        if(!$code){
            throw new ApiException('code不能为空', 1);
        }

        $code=Yii::$app->request->post('code');
        $message=json_decode(WxApi::getOpenid2($code),true);
        if($message['errcode']==0){
            $openid = $message['openid'];
        }else{
            throw new ApiException($message['errmsg'], 1);
        }
        if(!$openid){
            throw new ApiException('获取openid失败', 1);
        }
        $user=User::findOne($this->user['id']);
        $user->openid=$openid;
        $user->save();
        $jsonData['errmsg'] = '';
        $jsonData['detail']=[
            'openid'=>$openid
        ];
        return $jsonData;
    }


}