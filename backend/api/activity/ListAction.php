<?php

namespace backend\api\activity;
use backend\models\Activity;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use Yii;


class ListAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {
            $page_number=$this->RequestData('page_number',10);
        $page=$this->RequestData('page',1);
        $time=$this->RequestData('time');
        $month=$this->RequestData('month');
        $begin=($page-1)*$page_number;
        if($time){
            $query=Activity::find()->where(['<=','start_time',strtotime($time)+24*3600-1])->andWhere(['>=','end_time',strtotime($time)]);
        }else{
            if($month){
                $arr=explode('-',$month);
                $year=$arr[0];
                $month=$arr[1];
                $time_value="$year-$month-01";

                $start=strtotime(date("Y-m-01",strtotime($time_value)+31*24*3600));
                $end=strtotime(date("$time_value"));
                $query=Activity::find()->where(['<=','start_time',$start])->andWhere(['>=','end_time',$end]);
            }else{
                $start=strtotime(date('Y-m-01',strtotime('+1 month')));
                $end=strtotime(date('Y-m-01'));
                $query=Activity::find()->where(['<=','start_time',$start])->andWhere(['>=','end_time',$end]);
            }

        }

        $jsonData['total_pages']=ceil($query->count()/$page_number);
        $jsonData['total_count']=$query->count()*1;
        $model=$query->orderBy('sort asc,id desc')->offset($begin)->limit($page_number)->all();
        $jsonData['list']=[];
        foreach ($model as $k=>$v){
            $jsonData['list'][]=[
                'id'=>$v['id'],
                'title'=>$v['title'],
                'start_time'=>date('m-d H:i',$v['start_time']),
                'end_time'=>date('m-d H:i',$v['end_time']),
                'image'=>CommonFunction::setImg($v['image']),
                'number'=>$v['number'],
                'status'=>$v['status'],
                'address'=>$v['address'],
            ];
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }

}