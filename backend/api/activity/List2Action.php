<?php

namespace backend\api\activity;
use backend\models\Activity;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use Yii;


class List2Action extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {


        $page_number=$this->RequestData('page_number',10);
        $page=$this->RequestData('page',1);
        $month=$this->RequestData('month');
        $begin=($page-1)*$page_number;
        if($month){
            $arr=explode('-',$month);
            $year=$arr[0];
            $month=$arr[1];
            $time_value="$year-$month-01";

            $end=strtotime(date("Y-m-01",strtotime($time_value)+31*24*3600));
            $start=strtotime(date("$time_value"));
        }else{
            $end=strtotime(date('Y-m-01',strtotime('+1 month')));
            $start=strtotime(date('Y-m-01'));
        }

        $jsonData['total_pages']=1;
        $jsonData['total_count']=0;
        $jsonData['list']=[];
        while ($start<$end){
            $end2=$start+24*3600;
            $model=Activity::find()->where(['<=','start_time',$end2])->andWhere(['>=','end_time',$start])->orderBy('sort asc,id desc')->all();
            if(count($model)>0){
                if($jsonData['total_count']>=$begin and $jsonData['total_count']<($begin+$page_number)){
                    $list=[];
                    foreach ($model as  $k=>$v){
                        $list[]=[
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
                    $jsonData['list'][]=[
                        'time'=>date('Y年m月d日',$start),
                        'list'=>$list
                    ];
                }
                $jsonData['total_count']++;

            }
            $start=$start+24*3600;
        }
        $jsonData['total_pages']=ceil($jsonData['total_count']/$page_number);
        $jsonData['errmsg']='';
        return $jsonData;
    }

}