<?php

namespace backend\manager\pointRewardType;

use backend\models\PointRewardType;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;

/**
 * @Class SaveAction
 * @package backend\manager\pointRewardType
 * @User:五更的猫
 * @DateTime: 2023/12/13 14:16
 * @TODO 保存积分商品分类
 */
class SaveAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $id = $this->RequestData('id',null);
        $name = $this->RequestData('name',null);
        $sort = $this->RequestData('sort',null);
        $status = $this->RequestData('status',null);

        if(empty($name)){
            throw new ApiException('请填写分类名称',1);
        }
        if(empty($sort)){
            throw new ApiException('请填写排序',1);
        }
        if(empty($status) || !in_array($status,array(1,2))){
            throw new ApiException('请选择状态',1);
        }
        if(!empty($id)){
            $model = PointRewardType::findOne(['id'=>$id]);
            if(empty($model)){
                throw new ApiException('未找到此积分商品分类',1);
            }
        }else{
            $model = new PointRewardType();
        }
        $model->name = $name;
        $model->sort = $sort;
        $model->status = $status;

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id']=$model->id;

        return $jsonData;
    }

}