<?php

namespace backend\manager\UserHandover;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\UserHandover;
use backend\models\Employee;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class AuditAction extends ManagerApiAction
{
    protected function runAction()
    {

        $id = $this->RequestData('id',0);
        $status = $this->RequestData('status',0);



        $model = UserHandover::findOne($id);  
        if(empty($model)){
            throw new ApiException('没有此申请记录',1);
        }
 
        if($model->Audit($status)){

        }else{
            throw new ApiException("审核失败，错误：".$model->errmsg,1);

        }
 




    }

}