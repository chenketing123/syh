<?php

namespace backend\manager\LiveRoomAward;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\LiveRoomAward;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class EditAction extends ManagerApiAction
{
    protected function runAction()
    {

        $id = $this->RequestData('id',0);
        $goods_id = $this->RequestData('goods_id',0);
        $room_id = $this->RequestData('room_id',0);
        $is_calculation = $this->RequestData('is_calculation',1);
        $status = $this->RequestData('status',1);
 

        if(empty($goods_id)){
            throw new ApiException('产品不能为空',1);
        }
 

 
  
        $model = LiveRoomAward::findOne($id);
        if(empty($model)){
            $model = new LiveRoomAward();
        }
        $model->goods_id = $goods_id;
        $model->room_id = $room_id;
        $model->is_calculation = $is_calculation;
        $model->status = $status;
  

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;


    }

}