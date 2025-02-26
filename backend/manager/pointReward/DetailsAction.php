<?php

namespace backend\manager\pointReward;

use backend\models\PointReward;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\components\CommonFunction;
use common\exception\ApiException;
use Yii;

/**
 * @Class DetailsAction
 * @package backend\manager\pointRewardType
 * @User:五更的猫
 * @DateTime: 2023/12/13 15:15
 * @TODO 积分商品详情
 */
class DetailsAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $id = $this->RequestData('id',null);

        if(empty($id)){
            throw new ApiException('请选择积分商品',1);
        }
        $model = PointReward::findOne($id);
        if(empty($model)){
            throw new ApiException('未找到此积分商品记录',1);
        }
        $jsonData = array(
            'id'=>$model->id,
            'type_id' => $model->type_id,
            'award_id' => $model->award_id,
            'name' => $model->name,
            'cover' => CommonFunction::setImg($model->cover),
            'price' => $model->price,
            'point' => $model->point,
            'sort' => $model->sort,
            'status' => $model->status,
        );

        return $jsonData;
    }

}