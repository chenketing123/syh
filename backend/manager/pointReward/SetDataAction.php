<?php

namespace backend\manager\pointReward;

use backend\models\PointReward;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;

/**
 * @Class SetDataAction
 * @package backend\manager\pointRewardType
 * @User:五更的猫
 * @DateTime: 2023/12/13 14:23
 * @TODO 保存数据
 */
class SetDataAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $id = $this->RequestData('id',null);
        $sort = $this->RequestData('sort',null);
        $status = $this->RequestData('status',null);

        if(empty($id)){
            throw new ApiException('请选择积分商品',1);
        }
        if($sort===null && $status===null){
            throw new ApiException('请填写数据',1);
        }

        $model = PointReward::findOne(['id'=>$id]);
        if(empty($model)){
            throw new ApiException('未找到此积分商品',1);
        }
        if($sort!==null){
            $model->sort = $sort;
        }
        if($status!==null){
            $model->status = $status;
        }

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id']=$model->id;

        return $jsonData;
    }

}