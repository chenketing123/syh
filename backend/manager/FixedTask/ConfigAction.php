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
use common\helper\redis\RedisString;
use backend\models\Config;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class ConfigAction extends ManagerApiAction
{
    protected function runAction()
    {

        $Task_Audit_User = $this->RequestData('Task_Audit_User',0);
        $Task_Audit_Step = $this->RequestData('Task_Audit_Step',1);
 

        //清除缓存
        $key = Yii::$app->params['cacheName']['config'];
        RedisString::del($key);

        $model1 = Config::find()->where(['name'=>'Task_Audit_User'])->limit(1)->one();
        $model2 = Config::find()->where(['name'=>'Task_Audit_Step'])->limit(1)->one();

        if(empty($model1)){
            throw new ApiException('最后审核人未找到',1);
        }
        if(empty($model2)){
            throw new ApiException('审核层级未找到',1);
        }
 

        $model1->value = $Task_Audit_User;
        if(!$model1->save()){
            throw new ApiException('最后审核人保存失败',1);
        }
        $model2->value = $Task_Audit_Step;
        if(!$model2->save()){
            throw new ApiException('审核层级保存失败',1);
        }

 


    }

}