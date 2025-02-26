<?php

namespace backend\manager\role;

use backend\models\EmployeeRole;
use backend\models\ManagerRole;
use backend\models\Params;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\base\Exception;


/**
 * @Class DetailsAction
 * @package backend\api\employeeRole
 * @User:五更的猫
 * @DateTime: 2023/8/15 10:43
 * @TODO 角色详情
 */
class DetailsAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {
        $id = $this->RequestData('id',0);

        if (empty($id)) {
            throw new ApiException('请选择角色',1);
        }
        $model = ManagerRole::find()->andWhere(['id'=>$id])->one();

        if (empty($model)) {
            throw new ApiException('不存在此角色',1);
        }

        $jsonData = array(
            'id' => $model->id,
            'name' => $model->name,
            'date' => date('Y-m-d H:i:s',$model->append),
        );

        return $jsonData;
    }

}