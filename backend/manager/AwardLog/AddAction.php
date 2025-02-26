<?php

namespace backend\manager\AwardLog;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\AwardLog;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class AddAction extends ManagerApiAction
{
    protected function runAction()
    {

        $type = $this->RequestData('type',0);
        $user_id = $this->RequestData('user_id',0);
        $room_id = $this->RequestData('room_id',0);
        $activity_id = $this->RequestData('activity_id',0);
        $end_date = $this->RequestData('end_date','');
        $award_ids = $this->RequestData('award_ids','');
 

 



        if(empty($room_id)){
            throw new ApiException('直播间不能为空',1);
        }
        if(empty($award_ids)){
            throw new ApiException('可核销产品列表不能为空',1);
        }
 

 
        $model = new AwardLog();
        $model->send_type = 2;
        $model->type = $type;
        $model->scenario = 'send_add';
        $model->user_id = $user_id;
        $model->room_id = $room_id;
        $model->activity_id = $activity_id;
        $model->end_date = $end_date;
        $model->award_ids = $award_ids;


        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;


    }

}