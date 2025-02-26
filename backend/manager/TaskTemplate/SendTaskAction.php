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
use backend\models\ScheduledTask;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class SendTaskAction extends ManagerApiAction
{
    protected function runAction()
    {

        $id = $this->RequestData('id',0);

 


  
        $model = TaskTemplate::findOne($id);
        if(empty($model)){
            throw new ApiException('没有此任务模板',1);
        }

        $model->is_send = 2;
 
        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }





        
        if(ScheduledTask::addLog(1)){
            throw new ApiException('任务开始执行，请稍后查看',0);
        }else{
            throw new ApiException('执行任务失败',1);
        }



        $jsonData['id'] = $model->id;

        return $jsonData;




    }

}