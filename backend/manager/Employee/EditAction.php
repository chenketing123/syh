<?php

namespace backend\manager\Employee;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
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
        $market = $this->RequestData('market',0);
        $is_handover = $this->RequestData('is_handover',0);
        $is_blacklist = $this->RequestData('is_blacklist',0);
        $is_observe = $this->RequestData('is_observe',0);
        $is_statistics = $this->RequestData('is_statistics',0);

  
        $model = Employee::findOne($id);
        if(empty($model)){
            throw new ApiException('员工信息未找到'.$market,1);
        }

        $model->market = $market;
        $model->is_handover = $is_handover;
        $model->is_blacklist = $is_blacklist;
        $model->is_observe = $is_observe;
        $model->is_statistics = $is_statistics;
 
 
 
        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;




    }

}