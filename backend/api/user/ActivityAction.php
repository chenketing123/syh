<?php

namespace backend\api\user;
use backend\models\Activity;
use backend\models\ActivityUser;
use backend\models\Question;
use backend\models\Task;
use backend\models\UserIcon;
use backend\models\UserMedal;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use Yii;



class ActivityAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {



        $page_number=$this->RequestData('page_number',10);
        $page=$this->RequestData('page',1);
        $begin=($page-1)*$page_number;
        $query=ActivityUser::find()->where(['user_id'=>$this->user['id']]);
        $jsonData['total_pages']=ceil($query->count()/$page_number);
        $jsonData['total_count']=$query->count()*1;
        $model=$query->orderBy('id desc')->offset($begin)->limit($page_number)->all();
        $jsonData['list']=[];
        foreach ($model as $k=>$v){
            $activity=Activity::findOne($v['activity_id']);
            $jsonData['list'][]=[
                'id'=>$v['id'],
                'order_number'=>$v['order_number'],
                'price'=>$v['price'],
                'title'=>$activity['title'],
                'start_time'=>date('m-d H:i',$activity['start_time']),
                'end_time'=>date('m-d H:i',$activity['end_time']),
                'image'=>CommonFunction::setImg($activity['image']),
                'number'=>$activity['number'],
                'status'=>$activity['status'],
                'address'=>$activity['address'],
                'mobile'=>$v['mobile'],
                'name'=>$v['name'],
                'check_status'=>$v['status'],
                'paid_time'=>date('Y-m-d H:i',$v['paid_time']),
                'time'=>date('Y-m-d H:i',$v['created_at']),
                'pay_status'=>$v['pay_status'],
            ];
        }

        $jsonData['errmsg']='';
        return $jsonData;
    }
}