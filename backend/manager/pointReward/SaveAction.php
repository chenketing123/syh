<?php

namespace backend\manager\pointReward;

use backend\models\PointReward;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\components\CommonFunction;
use common\exception\ApiException;
use Yii;

/**
 * @Class SaveAction
 * @package backend\manager\pointRewardType
 * @User:五更的猫
 * @DateTime: 2023/12/13 14:16
 * @TODO 保存积分商品
 */
class SaveAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $id = $this->RequestData('id',null);
        $type_id = $this->RequestData('type_id',null);
        $award_id = $this->RequestData('award_id',null);
        $name = $this->RequestData('name',null);
        $cover = $this->RequestData('cover',null);
        $price = $this->RequestData('price',null);
        $point = $this->RequestData('point',null);
        $sort = $this->RequestData('sort',null);
        $status = $this->RequestData('status',null);

        if(empty($type_id)){
            throw new ApiException('请选择积分商品分类',1);
        }
        if(empty($award_id)){
            throw new ApiException('请选择关联核销产品',1);
        }
        if(empty($name)){
            throw new ApiException('请填写积分商品名称',1);
        }
        if(empty($cover)){
            throw new ApiException('请上传积分封面',1);
        }
        if($price===null){
            throw new ApiException('请填写积分商品价格',1);
        }
        if(empty($point)){
            throw new ApiException('请填写积分商品兑换积分',1);
        }
        if($sort===null){
            throw new ApiException('请填写排序',1);
        }
        if(empty($status) || !in_array($status,array(1,2))){
            throw new ApiException('请选择状态',1);
        }
        if(!empty($id)){
            $model = PointReward::findOne(['id'=>$id]);
            if(empty($model)){
                throw new ApiException('未找到此积分商品',1);
            }
        }else{
            $model = new PointReward();
        }
        $model->type_id = $type_id;
        $model->award_id = $award_id;
        $model->name = $name;
        $model->cover = CommonFunction::unsetImg($cover);
        $model->price = $price;
        $model->point = $point;
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