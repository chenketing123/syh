<?php

namespace backend\manager\OtherTask;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use backend\models\OtherTask;
use common\components\CommonFunction;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class DetailAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $id = $this->RequestData('id',0);

        $model = OtherTask::find()->where(['id'=>$id])->limit(1)->asArray()->one();
        if(empty($model)){
            throw new ApiException('其他任务未找到',1);
        }
 
        $model['employee_name'] = \backend\models\Employee::getName($model['employee_id']);
        $model['files'] = $model['files'] ? unserialize($model['files']) : array();
        foreach($model['files'] as $k => $v){
            $model['files'][$k] = CommonFunction::setImg($v);
        }


        $jsonData['model'] = $model;
 
        return $jsonData;
    }

}