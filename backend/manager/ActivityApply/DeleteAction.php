<?php

namespace backend\manager\ActivityApply;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\ActivityApply;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class DeleteAction extends ManagerApiAction
{
    protected function runAction()
    {

        $id = $this->RequestData('id',0);


        $delete = ActivityApply::findOne($id)->delete();

        if($delete)
        {
             
        }
        else
        {
            throw new ApiException('报名记录删除失败',1);
    
        } 
 


    }

}