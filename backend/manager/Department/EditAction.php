<?php

namespace backend\manager\Department;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\Department;


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
        $name = $this->RequestData('name','');
        $leader = $this->RequestData('leader',0);
 

        if(empty($name)){
            throw new ApiException('部门名称不能为空',1);
        }
 

        $model = Department::findOne($id);
        if(empty($name)){
            throw new ApiException('部门未找到',1);
        }


        $model->name = $name;
        $model->leader = $leader;

 
        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;


    }

}