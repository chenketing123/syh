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
class EditAction extends ManagerApiAction
{
    protected function runAction()
    {

        $id = $this->RequestData('id',0);
        $employee_id = $this->RequestData('employee_id',0);
        $is_show_live = $this->RequestData('is_show_live',1);

        $model = UserRoom::findOne($id);
        if(empty($model)){
            throw new ApiException('关系信息未找到',1);
        }
 
 
 
        $model->employee_id = $employee_id;
        $model->is_show_live = $is_show_live;
 
 
 
        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $model->UpdateMap();



    }

}