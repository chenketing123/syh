<?php

namespace backend\manager\LiveActivity;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\LiveActivity;


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
        $room_id = $this->RequestData('room_id',0);
        $name = $this->RequestData('name','');
        $year = $this->RequestData('year','');
        $month = $this->RequestData('month',1);
        $award_send_date = $this->RequestData('award_send_date','');
        $award_close_date = $this->RequestData('award_close_date','');
        $sort = $this->RequestData('sort',10);
        $status = $this->RequestData('status',1);


        if(empty($room_id)){
            throw new ApiException('直播间不能为空',1);
        }
        if(empty($name)){
            throw new ApiException('活动名称不能为空',1);
        }
        if(empty($award_send_date)){
            throw new ApiException('奖励发放截止时间不能为空',1);
        }
        if(empty($award_close_date)){
            throw new ApiException('奖励兑换截止时间不能为空',1);
        }

        if(empty($id)){
            $model = new LiveActivity();
        }else{
            $model = LiveActivity::findOne($id);
            if(empty($model)){
                throw new ApiException('未找到此直播活动',1);
            }
        }

        $model->room_id = $room_id;
        $model->name = $name;
        $model->year = $year;
        $model->month = $month;
        $model->award_send_date = $award_send_date;
        $model->award_close_date = $award_close_date;
        $model->sort = $sort;
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