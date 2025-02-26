<?php

namespace backend\manager\point;

use backend\models\User;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;

/**
 * @Class AddAction
 * @package backend\manager\point
 * @User:五更的猫
 * @DateTime: 2023/12/13 9:45
 * @TODO 修改用户积分
 */
class AddAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $room_id = $this->RequestData('room_id',null);
        $uid = trim($this->RequestData('uid',null));
        $price = $this->RequestData('price',0);
        $type = $this->RequestData('type',1);
        $msg = $this->RequestData('msg','');

        if(empty($room_id)){
            throw new ApiException('请选择直播间',1);
        }
        if(empty($uid)){
            throw new ApiException('请选择用户',1);
        }
        if(empty($price)){
            throw new ApiException('请填写积分',1);
        }
        if(empty($type)){
            throw new ApiException('请选择记录类型',1);
        }
        if(empty($msg)){
            throw new ApiException('请填写记录备注',1);
        }

        $user = User::findOne(['id'=>$uid]);

        if(empty($user)) {
            throw new ApiException('未找到此用户',1);
        }

        if (!$user->AddPoint($room_id, (int)$price, $msg, $type)) {
            throw new ApiException('添加积分失败',1);
        }

        $jsonData['errmsg']='添加积分成功';

        return $jsonData;
    }

}