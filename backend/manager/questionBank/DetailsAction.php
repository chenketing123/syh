<?php

namespace backend\manager\questionBank;

use backend\models\PointRewardType;
use backend\models\QuestionBank;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;

/**
 * @Class DetailsAction
 * @package backend\manager\questionBank
 * @User:五更的猫
 * @DateTime: 2023/12/13 17:24
 * @TODO 题目详情
 */
class DetailsAction extends ManagerApiAction
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

        $data =array();
        $content = json_decode($model->content,true);
        $answer = json_decode($model->answer,true);

        foreach ($content as $v){
            $data[]=array(
                'title'=>$v,
                'is_checked'=>in_array($v,$answer)?1:0,
            );
        }

        $jsonData = array(
            'id'=>$model->id,
            'title'=>$model->title,
            'type'=>$model->type,
            'status'=>$model->status,
            'sort'=>$model->sort,
            'data' => $data,
        );

        return $jsonData;
    }

}