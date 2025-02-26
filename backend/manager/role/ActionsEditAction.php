<?php

namespace backend\manager\role;

use backend\models\Actions;
use backend\models\ActionsRule;
use backend\models\EmployeeRole;
use backend\models\ManagerRole;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\components\CommonFunction;
use common\exception\ApiException;
use Yii;
use yii\base\Exception;


/**
 * @Class ActionsEditAction
 * @package backend\api\employeeRole
 * @User:五更的猫
 * @DateTime: 2023/8/15 11:27
 * @TODO 操作授权编辑
 */
class ActionsEditAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {
        $role_id  = $this->RequestData('role_id',0);
        $auth  = $this->RequestData('auth',array());

        if(empty($role_id)){
            throw new ApiException('请选择角色',1);
        }
        $model = ManagerRole::find()->andWhere(['id'=>$role_id])->one();

        if (empty($model)) {
            throw new ApiException('不存在此角色',1);
        }
        if(!is_array($auth)){
            $auth = explode(',',$auth);
        }

        //授权
        $AuthItemChild = new ActionsRule();
        $result = $AuthItemChild->accredit($role_id,$auth);

        if($result != true) {
            throw new ApiException('授权失败',1);
        }

        $jsonData['errmsg'] = '授权成功';


        return $jsonData;
    }

}