<?php

namespace backend\manager\sendPoint;

use backend\models\SendPoint;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;

/**
 * @Class AddAction
 * @package backend\manager\point
 * @User:五更的猫
 * @DateTime: 2023/12/13 9:45
 * @TODO 保存观看积分发放设置
 */
class SaveAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $id = $this->RequestData('id',null);
        $room_id = $this->RequestData('room_id',null);
        $time = $this->RequestData('time',0);
        $point = $this->RequestData('point',0);

        if(empty($room_id)){
            throw new ApiException('请选择直播间',1);
        }
        if(empty($time)){
            throw new ApiException('请填写时长',1);
        }
        if(empty($point)){
            throw new ApiException('请填写积分',1);
        }
        if(!empty($id)){
            $model = SendPoint::findOne(['id'=>$id]);
            if(empty($model)){
                throw new ApiException('未找到此观看积分发放设置记录',1);
            }
        }else{
            $model = new SendPoint();
        }
        $model->room_id = $room_id;
        $model->time = $time;
        $model->point = $point;

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id']=$model->id;

        return $jsonData;
    }

}