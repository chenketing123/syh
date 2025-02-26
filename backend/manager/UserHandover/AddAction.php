<?php

namespace backend\manager\UserHandover;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\UserHandover;
use backend\models\Employee;


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

        $out_user = $this->RequestData('out_user',0);
        $room_id = $this->RequestData('room_id',0);
        $user_ids = $this->RequestData('user_ids','');
        $in_user = $this->RequestData('in_user',0);
        $handover_user = $this->RequestData('handover_user',0);
        $remark = $this->RequestData('remark','');
        $images = $this->RequestData('images','');
        $date = $this->RequestData('date','');



        
        if(empty($out_user) || empty($room_id)){
            throw new ApiException('请选择交接人和直播间',1);
        }
 

        $model = new UserHandover;
        $model->out_user = $out_user;
        $model->in_user = $in_user;
        $model->handover_user = $handover_user;
        $model->room_id = $room_id;
        $model->out_user_name = Employee::getName($model->out_user);
        $model->in_user_name = Employee::getName($model->in_user);
        $model->handover_user_name = Employee::getName($model->handover_user);
        $model->user_ids = $user_ids;
        $model->remark = $remark;
        $model->images = CommonFunction::unsetImg($images);
        $model->date = $date;
        $model->province = 0;
        $model->city = 0;
        $model->district = 0;
        $model->employee_id = 0;
        $model->employee_name = '系统后台';




        if (!$model->save()) {
            $error = $model->getErrors();
            $error = reset($error);
            $error = reset($error);

            throw new ApiException($error,1);

        }
 
 
 



    }

}