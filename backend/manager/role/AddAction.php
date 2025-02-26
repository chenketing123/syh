<?php

namespace backend\manager\role;

use backend\models\EmployeeRole;
use backend\models\ManagerRole;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;

/**
 * @Class AddAction
 * @package backend\api\employeeRole
 * @User:五更的猫
 * @DateTime: 2023/8/15 10:41
 * @TODO 添加角色
 */
class AddAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {
        $name = $this->RequestData('name','');

        if (empty($name)) {
            throw new ApiException('请填写角色名称',1);
        }
        $model = new ManagerRole();
        $model->loadDefaultValues();

        $model->name = $name;

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;
    }

}