<?php

namespace backend\api\activity;
use backend\models\Activity;
use backend\models\ActivityUser;
use backend\models\User;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\components\Helper;
use common\exception\ApiException;
use Yii;


class CheckAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {
        $id = $this->RequestData('id');
        $model = Activity::findOne($id);
        if (!$model) {
            throw new ApiException('id不正确', 1);
        }
        $old=ActivityUser::find()->where(['activity_id'=>$id,'user_id'=>$this->user['id'],'pay_status'=>2])->limit(1)->one();
        if($old){
            if($old->pay_status==1){
                throw new ApiException('未付款', 1);
            }
            if($old->status==1){
                $old->status=2;
                $old->save();
            }else{
                throw new ApiException('已经签到过了', 1);
            }
        }else{
            $mobile=$this->RequestData('mobile');
            $name=$this->RequestData('name');
            if(!$mobile){
                throw new ApiException('请填写手机号', 1);
            }
            $old2=ActivityUser::find()->where(['activity_id'=>$id,'mobile'=>$mobile,'pay_status'=>2])->limit(1)->one();
            if($old2->pay_status==1){
                throw new ApiException('未付款', 1);
            }
            if($old2){
                if($old2->status==1){
                    $old2->status=2;
                    $old2->save();
                }else{
                    throw new ApiException('已经签到过了', 1);
                }
            }else{
                throw new ApiException('您未报名该活动', 1);
            }
        }

        $jsonData['errmsg'] = '';
        return $jsonData;
    }

}