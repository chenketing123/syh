<?php

namespace backend\manager\AwardQuota;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\AwardQuota;


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
        $code = $this->RequestData('code','');
        $room_id = $this->RequestData('room_id',0);
        $number = $this->RequestData('number',0);
 

        if(empty($room_id)){
            throw new ApiException('直播间不能为空',1);
        }
        if(empty($code)){
            throw new ApiException('邀请码不能为空',1);
        }
 

 
  
        $model = AwardQuota::findOne($id);
        if(empty($model)){
            $model = new AwardQuota();
        }
        $model->code = $code;
        $model->room_id = $room_id;
        $model->number = $number;
  
 

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;


    }

}