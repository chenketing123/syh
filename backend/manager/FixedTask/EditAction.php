<?php

namespace backend\manager\FixedTask;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\FixedTask;
use backend\models\FixedTaskLog;


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
        $minimum = $this->RequestData('minimum',0);
        $punish = $this->RequestData('punish',0);
        $sprint1 = $this->RequestData('sprint1',0);
        $sprint1_award = $this->RequestData('sprint1_award',0);
        $sprint2 = $this->RequestData('sprint2',0);
        $sprint2_award = $this->RequestData('sprint2_award',0);
        $sprint3 = $this->RequestData('sprint3',0);
        $sprint3_award = $this->RequestData('sprint3_award',0);

 


        $model = FixedTask::findOne($id);
        if(empty($model)){
            throw new ApiException('固定任务不能为空',1);
        }
 
 
        $model->minimum = $minimum;
        $model->punish = $punish;
        $model->sprint1 = $sprint1;
        $model->sprint1_award = $sprint1_award;
        $model->sprint2 = $sprint2;
        $model->sprint2_award = $sprint2_award;
        $model->sprint3 = $sprint3;
        $model->sprint3_award = $sprint3_award;
 

 

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }
        FixedTaskLog::AddLog($model,0,2);

        $jsonData['id'] = $model->id;

        return $jsonData;


    }

}