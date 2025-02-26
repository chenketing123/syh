<?php

namespace backend\manager\pointRewardType;

use backend\models\PointRewardType;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;

/**
 * @Class DelAction
 * @package backend\manager\point
 * @User:五更的猫
 * @DateTime: 2023/12/13 11:36
 * @TODO 删除记录
 */
class DelAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $id = $this->RequestData('id',null);

        if(empty($id)){
            throw new ApiException('请选择积分商品分类',1);
        }
        $model = PointRewardType::findOne($id);
        if(empty($model)){
            throw new ApiException('未找到此积分商品分类记录',1);
        }
        if(!$model->delete()){
            throw new ApiException('删除失败',1);
        }
        $jsonData = array(
            'id'=>$model->id,
        );

        return $jsonData;
    }

}