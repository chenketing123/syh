<?php

namespace backend\api\user;
use backend\models\Book;
use backend\models\BookDetail;
use backend\models\UserCheck;
use common\base\api\CommonApiAction;
use common\components\Helper;
use Yii;



class ListAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {





        $time=$this->RequestData('time',date('Y-m'));
        $arr=explode('-',$time);
        $year=$arr[0];
        $month=$arr[1];
        $start=strtotime("$year-$month-01");
        $end=strtotime(date('Y-m-01',$start+31*24*3600));
        $type=$this->RequestData('type','');
        $user_id=$this->RequestData('user_id');
        if(!$user_id){
            $user_id=$this->user['id'];
        }
        $model=UserCheck::find()->where(['user_id'=>$user_id])->andFilterWhere(['type'=>$type])->andWhere(['>=','time',$start])->andWhere(['<','time',$end])->all();
        $jsonData['list']=[];

        $message=[];
        while($start<$end){
            $show_time=date('Y-m-d',$start);
            $message[$show_time]=[
                'time'=>$show_time,
                'is_task'=>0,
                'is_read'=>0,
            ];
            $start=$start+24*3600;
        }

        $jsonData['total_number']=0;
        $jsonData['read_number']=0;
        $jsonData['unread_number']=0;
        $arr_value=[];
        $arr_value2=[];
        $arr_value3=[];
        foreach ($model as $k=>$v){
            $now_time=date('Y-m-d',$v['time']);
            if(isset($message[$now_time])){
                $message[$now_time]['is_task']=1;
                if(strtotime($now_time)<=time()){
                    if(!in_array($now_time,$arr_value)){
                        $jsonData['total_number']++;
                        $arr_value[]=$now_time;
                    }
                }
                if($v['status']==2){
                    if(strtotime($now_time)<=time()){
                        if(!in_array($now_time,$arr_value2)){
                            $arr_value2[]=$now_time;
                        }
                    }
                }else{
                    if(strtotime($now_time)<=time()) {
                        if(!in_array($now_time,$arr_value3)){
                            $arr_value3[]=$now_time;
                        }
                    }
                }
            }
        }
        foreach ($arr_value2 as $k=>$v){
            $message[$v]['is_read']=1;
            if(in_array($v,$arr_value3)){
                $key=array_search($v,$arr_value2);
                unset($arr_value2[$key]);
            }
        }
        foreach ($arr_value2 as $k=>$v){
            $jsonData['read_number']++;
        }
        foreach ($arr_value3 as $k=>$v){
            $message[$v]['is_read']=0;
            $jsonData['unread_number']++;
        }
        foreach ($message as $k=>$v){
            $jsonData['list'][]=$v;
        }

        $jsonData['errmsg']='';
        return $jsonData;
    }
}