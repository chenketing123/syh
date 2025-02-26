<?php

namespace backend\manager\UserRoom;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\UserRoom;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class ResumeAllAction extends ManagerApiAction
{
    protected function runAction()
    {

        $ids = $this->RequestData('ids','');

        if(empty($ids)){
            throw new ApiException('请选择需要恢复的用户',1);
        }

        UserRoom::updateAll(['is_show_live'=>1],['in','id',explode(',',$ids)]);



    }

}