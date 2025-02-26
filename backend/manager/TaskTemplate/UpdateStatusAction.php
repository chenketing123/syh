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
class UpdateStatusAction extends ManagerApiAction
{
    protected function runAction()
    {

        $id = $this->RequestData('id',0);
        $status = $this->RequestData('status',1);
 
  
        $model = TaskTemplate::findOne($id);
        if(empty($model)){
            throw new ApiException('固定任务模板未找到',1);
        }

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