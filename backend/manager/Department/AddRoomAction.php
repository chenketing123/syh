<?php

namespace backend\manager\Department;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\Department;
use backend\models\Employee;
use backend\models\EmployeeRoom;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class AddRoomAction extends ManagerApiAction
{
    protected function runAction()
    {

        $department_id = $this->RequestData('department_id',0);
        $type = $this->RequestData('type',0);
        $room_id = $this->RequestData('room_id',array());
 

        if(!in_array($type,array(1,2))){
            throw new ApiException('请选择添加类型',1);
        }
        if(empty($room_id)){
            throw new ApiException('请选择直播间',1);
        }

 

        if($type == 2){
            $employee = Employee::find()->andWhere('FIND_IN_SET("' . $department_id . '",`department_arr`)')->all();
        }else{
            $employee = Employee::find()->where(['main_department'=>$department_id])->all();
        }
        foreach ($employee as $value) {
            EmployeeRoom::deleteAll(['employee_id'=>$value['id']]);
        }

        sleep(3);
        
        $room_id = explode(',',$room_id);
        foreach ($employee as $value) {
            foreach ($room_id as $v) {
                $model = new EmployeeRoom();
                $model->employee_id = $value['id'];
                $model->room_id = $v;
                $model->save();
            }
        }
 

 


    }

}