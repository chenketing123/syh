<?php

namespace backend\manager\questionBank;

use backend\models\PointRewardType;
use backend\models\QuestionBank;
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
            throw new ApiException('请选择答题库记录',1);
        }
        $model = QuestionBank::findOne($id);
        if(empty($model)){
            throw new ApiException('未找到此答题库记录',1);
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