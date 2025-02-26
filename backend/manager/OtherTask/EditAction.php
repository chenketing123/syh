<?php

namespace backend\manager\OtherTask;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\OtherTask;
use backend\models\OtherTaskLog;


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
        $task_id = $this->RequestData('task_id',0);
        $employee_id = $this->RequestData('employee_id',0);
        $title = $this->RequestData('title','');
        $user_id = $this->RequestData('user_id',0);
        $confirmor1 = $this->RequestData('confirmor1',0);
        $confirmor2 = $this->RequestData('confirmor2',0);
        $perf = $this->RequestData('perf',0);
        $day = $this->RequestData('day',0);
        $intro = $this->RequestData('intro','');
        $files = $this->RequestData('files','');
        $month = $this->RequestData('month',0);
        $start_time = $this->RequestData('start_time','');
        $end_time = $this->RequestData('end_time','');

        if(empty($employee_id)){
            throw new ApiException('创建人不能为空',1);
        }
        if(empty($title)){
            throw new ApiException('标题不能为空',1);
        }
        if(empty($user_id)){
            throw new ApiException('负责人不能为空',1);
        }
        if(empty($confirmor1)){
            throw new ApiException(' 确认人1 不能为空',1);
        }
        if(empty($confirmor2)){
            throw new ApiException('确认人2不能为空',1);
        }
        if(empty($month)){
            throw new ApiException('月份不能为空',1);
        }

        if(empty($id)){
            $model = new OtherTask;

            if(!empty($task_id) && empty($id)){
                $model->task_id = $task_id;
                $model->task_type = 2;
            }
        }else{
            $model = OtherTask::findOne($id);
            if(empty($model)){
                throw new ApiException('未找到此任务',1);
            }
            if($model->status!=1) {
                throw new ApiException('任务已标记完成，无法修改',1);
            }
        }

        $model->employee_id = $employee_id;
        $model->title = $title;
        $model->user_id = $user_id;
        $model->confirmor1 = $confirmor1;
        $model->confirmor2 = $confirmor2;
        $model->perf = $perf;
        $model->day = $day;
        $model->intro = $intro;
        $model->month = $month;
        $model->start_time = $start_time;
        $model->end_time = $end_time;

        $files = !is_array($files) ? explode(',',$files) : array();
        foreach($files as $k => $v){
            $files[$k] = CommonFunction::unsetImg($v);
        }
        $model->files = $files;


 

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }
 
        $jsonData['id'] = $model->id;

        return $jsonData;


    }

}