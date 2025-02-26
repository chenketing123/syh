<?php

namespace backend\manager\TaskTemplate;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\TaskTemplate;


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
        $department_ids = $this->RequestData('department_ids','');
        $user_ids = $this->RequestData('user_ids','');
        $start_time = $this->RequestData('start_time',0);
        $end_time = $this->RequestData('end_time',0);
        $statistics_time = $this->RequestData('statistics_time',0);
        $data_ids = $this->RequestData('data_ids','');
        $text_ids = $this->RequestData('text_ids','');
        $task_audit_step = $this->RequestData('task_audit_step',0);
        $task_audit_user = $this->RequestData('task_audit_user',0);
        $status = $this->RequestData('status',1);

 



        if(empty($department_ids)){
            throw new ApiException('负责部门不能为空',1);
        }
        if(empty($user_ids)){
            throw new ApiException('负责人不能为空',1);
        }
        if(empty($statistics_time)){
            throw new ApiException('统计关账时间不能为空',1);
        }
        if(empty($data_ids)){
            throw new ApiException('数据型任务不能为空',1);
        }
        if(empty($text_ids)){
            throw new ApiException('文字型任务不能为空',1);
        }

 

 
  
        $model = TaskTemplate::findOne($id);
        if(empty($model)){
            $model = new TaskTemplate();
        }
        $model->department_ids = $department_ids;
        $model->user_ids = $user_ids;
        $model->start_time = $start_time;
        $model->end_time = $end_time;
        $model->statistics_time = $statistics_time;
        $model->data_ids = $data_ids;
        $model->text_ids = $text_ids;
        $model->task_audit_step = $task_audit_step;
        $model->task_audit_user = $task_audit_user;
        $model->status = $status;
        $model->target_time = 0;

 

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;


    }

}