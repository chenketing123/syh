<?php

namespace backend\manager\role;

use backend\models\EmployeeRole;
use backend\models\ManagerRole;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;

/**
 * @Class EditAction
 * @package backend\api\employeeMenu
 * @User:五更的猫
 * @DateTime: 2023/8/14 17:32
 * @TODO 修改菜单
 */
class EditAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {
        $name = $this->RequestData('name','');

        if (empty($name)) {
            throw new ApiException('请填写角色名称',1);
        }
        $id = $this->RequestData('id',0);

        if (empty($id)) {
            $model = new ManagerRole();
            $model->loadDefaultValues();
        }else{
            $model = ManagerRole::find()->andWhere(['id'=>$id])->one();

            if (empty($model)) {
                throw new ApiException('不存在此角色',1);
            }
        }
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