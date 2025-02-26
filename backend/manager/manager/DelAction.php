<?php

namespace backend\manager\manager;

use backend\models\Manager;
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
            throw new ApiException('请选择管理员账号',1);
        }
        $model = Manager::findOne($id);
        if(empty($model)){
            throw new ApiException('未找到此管理员账号',1);
        }

        if(!$model->delete()){
            throw new ApiException('删除账号失败',1);
        }
        $jsonData['id'] = $id;
        return $jsonData;
    }

}