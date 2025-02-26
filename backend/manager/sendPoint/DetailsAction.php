<?php

namespace backend\manager\sendPoint;

use backend\models\LiveRoom;
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
 * @TODO 观看积分发放设置详情
 */
class DetailsAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $id = $this->RequestData('id',null);

        if(empty($id)){
            throw new ApiException('请选择观看积分发放设置记录',1);
        }
        $model = SendPoint::findOne($id);
        if(empty($model)){
            throw new ApiException('未找到此观看积分发放设置记录',1);
        }
        $jsonData = array(
            'id'=>$model->id,
            'room_id'=>$model->room_id,
            'room_text' => LiveRoom::getName($model['room_id']),
            'time'=>$model->time,
            'point'=>$model->point,
        );

        return $jsonData;
    }

}