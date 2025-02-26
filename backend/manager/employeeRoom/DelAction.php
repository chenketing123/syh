<?php

namespace backend\manager\employeeRoom;

use backend\models\EmployeeRoom;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;

/**
 * @Class DetailsAction
 * @package backend\manager\pointRewardType
 * @User:五更的猫
 * @DateTime: 2023/12/13 15:15
 * @TODO 删除管理员
 */
class DelAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $id = $this->RequestData('id',null);

        if(empty($id)){
            throw new ApiException('请选择员工直播间关系',1);
        }
        $model = EmployeeRoom::findOne($id);
        if(empty($model)){
            throw new ApiException('未找到此员工直播间关系',1);
        }

        if(!$model->Del()){
            throw new ApiException('删除失败，员工直播间存在下级用户，请处理后再删除',1);
        }
        $jsonData['id'] = $id;
        return $jsonData;
    }

}