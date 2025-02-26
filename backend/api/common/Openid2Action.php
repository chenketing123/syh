<?php

namespace backend\api\common;

use backend\models\User;
use common\base\api\ApiAction;
use common\components\Weixin;
use common\components\WxApi;
use common\exception\ApiException;
use Yii;
use yii\base\BaseObject;


class Openid2Action extends ApiAction
{


    public $isSign = true;
    public $isLogin=true;

    protected function runAction()
    {


        $user=User::findOne($this->user['id']);
        if($user->openid){
            $status=2;
        }else{
            $status=1;
        }
        $jsonData['errmsg'] = '';
        $jsonData['detail']=[
            'status'=>$status
        ];
        return $jsonData;
    }


}