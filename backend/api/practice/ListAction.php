<?php

namespace backend\api\practice;
use backend\models\Practice;
use backend\models\PracticeUser;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use Yii;


class ListAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $id=$this->RequestData('id');
        $model=Practice::find()->where(['category_id'=>$id])->orderBy('sort asc,id desc')->all();
        $jsonData['list']=[];
        $total_number=0;
        $read_number=0;
        $unread_number=0;
        foreach ($model as $k=>$v){
            $total_number++;
            $user_task=PracticeUser::find()->where(['user_id'=>$this->user['id'],'practice_id'=>$v['id']])->limit(1)->one();
            $status=1;
            if($user_task){
                $read_number++;
                $status=2;
            }else{
                $unread_number++;
            }
            $jsonData['list'][]=[
                'id'=>$v['id'],
                'title'=>$v['title'],
                'status'=>$status,
                'start_time'=>date('Y-m-d',$v['start_time']),
                'end_time'=>date('Y-m-d',$v['end_time']),
                'image'=>CommonFunction::setImg($v['image']),
            ];
        }
        $jsonData['errmsg']='';
        $jsonData['total_number']=$total_number;
        $jsonData['read_number']=$read_number;
        $jsonData['unread_number']=$unread_number;
        return $jsonData;
    }

}