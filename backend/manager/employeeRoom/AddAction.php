<?php

namespace backend\manager\employeeRoom;

use backend\models\EmployeeRoom;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;

/**
 * @Class SaveAction
 * @package backend\manager\note
 * @User:五更的猫
 * @DateTime: 2023/12/13 16:25
 * @TODO 新增修改管理员
 */
class AddAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $employee_id = $this->RequestData('employee_id',null);
        $room_id = $this->RequestData('room_id',array());

        if(empty($employee_id)){
            throw new ApiException('请选择员工',1);
        }
        if(empty($room_id)){
            throw new ApiException('请选择直播间',1);
        }
        $room_id = is_array($room_id)?$room_id:explode(',',$room_id);

        foreach ($room_id as $v){
            $model = new EmployeeRoom();
            $model->employee_id = $employee_id;
            $model->room_id = $v;
            $model->save();
        }

        $jsonData['errmsg']='添加成功';

        return $jsonData;
    }

}