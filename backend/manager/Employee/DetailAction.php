<?php

namespace backend\manager\Employee;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use backend\models\Employee;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class DetailAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $id = $this->RequestData('id',0);

        $model = Employee::find()->where(['id'=>$id])->asArray()->limit(1)->one();
        $one = Employee::find()->where(['id'=>$id])->limit(1)->one();
        if(empty($model)){
            throw new ApiException('员工未找到',1);
        }

        $model['avatar'] = $one->getImg();


        $model['employee_name'] = \backend\models\Employee::getName($model['employee_id']);
        $model['department_name'] = $one->GetDepartment();
        $model['gender_string'] = \backend\models\Params::$sex2[$model['gender']];
        $model['status_string'] = \backend\models\Employee::$status[$model['status']];
        $model['main_department_string'] = \backend\models\Department::getName($model['main_department']);

        $model['is_leader_string'] = \backend\models\Params::$is[$model['is_leader']];
        $model['market_string'] = \backend\models\Market::getName($model['market']);
        $model['is_handover_string'] = \backend\models\Params::$is[$model['is_handover']];
        $model['is_blacklist_string'] = \backend\models\Params::$is[$model['is_blacklist']];
        $model['is_observe_string'] = \backend\models\Params::$is[$model['is_observe']];
        $model['is_statistics_string'] = \backend\models\Params::$is[$model['is_statistics']];

            

        

        $jsonData['model'] = $model;
 
        return $jsonData;
    }

}