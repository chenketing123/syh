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


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class DeleteAllAction extends ManagerApiAction
{
    protected function runAction()
    {

        $ids = $this->RequestData('ids','');

        if(empty($ids)){
            throw new ApiException('请选择需要删除的记录',1);
        }
        FixedTask::deleteAll(['in','id',explode(',',$ids)]);

 
 


    }

}