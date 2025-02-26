<?php

namespace backend\api\team;
use backend\models\Team;
use backend\models\User;
use backend\models\UserCheck;
use backend\models\UserTeam;
use common\base\api\CommonApiAction;
use common\components\Helper;
use common\exception\ApiException;
use Yii;



class CheckMobileAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {



        $mobile=$this->RequestData('mobile');
        $user=User::findOne(['mobile_phone'=>$mobile]);
        if(!$user){
            throw new ApiException('这个号码用户不存在', 1);
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }
}