<?php

namespace backend\api\user;
use backend\models\Activity;
use backend\models\ActivityUser;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use Yii;



class ActivityDetailAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {



        $id=$this->RequestData('id');
        $model=ActivityUser::findOne($id);
        $jsonData['detail']=[];
            $activity=Activity::findOne($model['activity_id']);
            if($model->paid_time>0){
                $paid_time=date('Y-m-d H:i',$model->paid_time);
            }else{
                $paid_time='';
            }
            $jsonData['detail']=[
                'id'=>$model['id'],
                'order_number'=>$model['order_number'],
                'price'=>$model['price'],
                'title'=>$activity['title'],
                'start_time'=>date('m-d H:i',$activity['start_time']),
                'end_time'=>date('m-d H:i',$activity['end_time']),
                'image'=>CommonFunction::setImg($activity['image']),
                'number'=>$activity['number'],
                'status'=>$activity['status'],
                'address'=>$activity['address'],
                'mobile'=>$model['mobile'],
                'name'=>$model['name'],
                'check_status'=>$model['status'],
                'paid_time'=>$paid_time,
                'time'=>date('Y-m-d H:i',$model['created_at']),
                'pay_status'=>$model['pay_status'],
            ];
 

        $jsonData['errmsg']='';
        return $jsonData;
    }
}