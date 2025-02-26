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
use yii\base\BaseObject;


class ApplyAction extends CommonApiAction
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
//        $old=ActivityUser::find()->where(['activity_id'=>$id,'user_id'=>$this->user['id']])->limit(1)->one();
//        if($old){
//            throw new ApiException('您已经报过名了', 1);
//        }else{
//            $mobile=$this->RequestData('mobile');
//            $name=$this->RequestData('name');
//            if(!$mobile){
//                throw new ApiException('请填写手机号', 1);
//            }
//            $old2=ActivityUser::find()->where(['activity_id'=>$id,'mobile'=>$mobile])->limit(1)->one();
//            if($old2){
//                throw new ApiException('该电话已经报过名', 1);
//            }
//            if(!$name){
//                throw new ApiException('请填写姓名', 1);
//            }
//            $new=new ActivityUser();
//
//            $new->user_id=$this->user['id'];
//            $new->mobile=$mobile;
//            $new->name=$name;
//            $new->activity_id=$id;
//            $new->price=$model['price'];
//            if($model['price']<=0){
//                $new->pay_status=2;
//                $new->paid_time=time();
//            }
//            $new->order_number=date('YmdHi').$this->user['id'].mt_rand(100,999);
//            $new->save();
//        }

        $count=ActivityUser::find()->where(['activity_id'=>$id])->count();
        if($count>=$model['number']){
            throw new ApiException('报名人数已满', 1);
        }

        $mobile=$this->RequestData('mobile');
        $name=$this->RequestData('name');
        if(!$mobile){
            throw new ApiException('请填写手机号', 1);
        }
        $old2=ActivityUser::find()->where(['activity_id'=>$id,'mobile'=>$mobile])->limit(1)->one();
        if($old2){
            if($old2->user_id!=$this->user['id']){
                throw new ApiException('该手机号其他人报过名了', 1);
            }else{
                if($old2->pay_status==1){
                    $jsonData['errmsg'] = '';
                    $jsonData['order_id']=$old2->id;
                    $jsonData['status']=2;
                    return $jsonData;
                }else{
                    throw new ApiException('该手机号已报名', 1);
                }

            }
        }
        if(!$name){
            throw new ApiException('请填写姓名', 1);
        }
        $new=new ActivityUser();

        $new->user_id=$this->user['id'];
        $new->mobile=$mobile;
        $new->name=$name;
        $new->activity_id=$id;
        $new->price=$model['price'];
        $new->is_kb=$this->RequestData('is_kb',0);
        if($model['price']<=0){
            $new->pay_status=2;
            $new->paid_time=time();
        }
        $new->order_number=date('YmdHi').$this->user['id'].mt_rand(100,999);
        $new->save();

        $jsonData['errmsg'] = '';
        $jsonData['order_id']=$new->id;
        $jsonData['status']=1;
        return $jsonData;
    }

}