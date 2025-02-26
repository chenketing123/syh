<?php

namespace backend\manager\OtherTaskLog;

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

        $task_id = $this->RequestData('task_id',0);
        $content = $this->RequestData('content',0);
        $files = $this->RequestData('files','');
 
        if(empty($task_id)){
            throw new ApiException('请选择任务',1);
        }
        if(empty($content)){
            throw new ApiException('内容不能为空',1);
        }
 
        $model = new OtherTaskLog;
        $model->task_id = $task_id;
        $model->type = 4;
        $model->user_id = 0;
        $model->user_name = '系统';
        $model->content = $content;

        $files = $files ? explode(',',$files) : array();
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