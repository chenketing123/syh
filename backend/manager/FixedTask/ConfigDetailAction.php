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
class ConfigDetailAction extends ManagerApiAction
{
    protected function runAction()
    {

 
        $jsonData['Task_Audit_User'] =Yii::$app->config->info('Task_Audit_User');
        $jsonData['Task_Audit_Step'] = Yii::$app->config->info('Task_Audit_Step');
 

        return $jsonData;

 


    }

}