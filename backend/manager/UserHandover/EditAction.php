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
class EditAction extends ManagerApiAction
{
    protected function runAction()
    {

        $id = $this->RequestData('id',0);
        $user_ids = $this->RequestData('user_ids','');
        $in_user = $this->RequestData('in_user',0);
        $handover_user = $this->RequestData('handover_user',0);
        $remark = $this->RequestData('remark','');
        $images = $this->RequestData('images','');
        $date = $this->RequestData('date','');



        $model = UserHandover::findOne($id);  
        if(empty($model)){
            throw new ApiException('未找到交接信息',1);
        }
        if($model->status != 1){
            throw new ApiException('此申请记录已处理，无法修改',1);
        }

 
        if($in_user != $model->in_user){
            $model->in_user_name = Employee::getName($in_user);
        }
        $model->in_user = $in_user;
        if($handover_user != $model->handover_user){
            $model->handover_user_name = Employee::getName($handover_user);
        }
        $model->handover_user = $handover_user;

        $model->user_ids = explode(',',$user_ids);
        $model->remark = $remark;
        $model->images = CommonFunction::unsetImg($images);
        $model->date = $date;





        if (!$model->save()) {
            $error = $model->getErrors();
            $error = reset($error);
            $error = reset($error);

            throw new ApiException($error,1);

        }



    }

}