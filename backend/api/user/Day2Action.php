<?php

namespace backend\api\user;
use backend\models\Activity;
use backend\models\Book;
use backend\models\BookDetail;
use backend\models\UserCheck;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\components\Helper;
use Yii;



class Day2Action extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {


        $time=$this->RequestData('month',date('Y-m'));
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




        $user_id=$this->user['id'];
        $page_number=$this->RequestData('page_number',10);
        $page=$this->RequestData('page',1);
        $month=$this->RequestData('month',date('Y-m'));
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
            $end2=$start+24*3600-1;
            $time=strtotime(date('Y-m-d',$start));
            $model=Activity::find()->where(['<=','start_time',$end2])->andWhere(['>=','end_time',$start])->orderBy('sort asc,id desc')->all();
            $model2=UserCheck::find()->where(['user_id'=>$user_id,'time'=>$time])->all();
            if(count($model)>0 or count($model2)>0){
                if($jsonData['total_count']>=$begin and $jsonData['total_count']<($begin+$page_number)){
                    $list=[];
                    $activity=[];
                    foreach ($model as  $k=>$v){
                        $activity[]=[
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


                    $status_now=2;
                    foreach ($model2 as $k=>$v){
                        if($v['status']==1){
                            $status_now=1;
                        }
                        $book=Book::findOne($v['book_id']);
                        $detail=BookDetail::findOne($v['detail_id']);
                        if($book and $detail){
                            $arr_value=[];
                            if($v['image']){
                                $arr_image=explode(',',$v['image']);
                                foreach ($arr_image as $k2=>$v2){
                                    $arr_value[]=CommonFunction::setImg($v2);
                                }
                            }

                            $user_task=[
                                'content'=>$v['content'],
                                'image'=>$arr_value,
                                'file'=>CommonFunction::setImg($v['file']),
                                'time'=>date('Y-m-d H:i',$v['check_time']),
                                'file_time'=>$v['file_time'],
                            ];
                            $total_number=UserCheck::find()->where(['time'=>$time,'type'=>$v['type'],'relation_id'=>$v['relation_id'],'detail_id'=>$v['detail_id']])->count()*1;
                            $read_number=UserCheck::find()->where(['time'=>$time,'type'=>$v['type'],'relation_id'=>$v['relation_id'],'detail_id'=>$v['detail_id'],'status'=>2])->count()*1;
//                            $title=$book->title;
//                            if($detail['number1']>0){
//                                $title.='第'.$detail['number1'].'章';
//                            }
//                            if($detail['number2']>0){
//                                $title.='第'.$detail['number2'].'节';
//                            }
                            $title=$detail['title'];
                            $list[]=[
                                'id'=>$v['id'],
                                'image'=>Helper::imageUrl2($book['image']),
                                'title'=>$title,
                                'status'=>$v['status'],
                                'type'=>$v['type'],
                                'user_task'=>$user_task,
                                'total_number'=>$total_number,
                                'read_number'=>$read_number,
                            ];
                        }
                    }

                    $jsonData['list'][]=[
                        'time'=>date('Y年m月d日',$start),
                        'list'=>$list,
                        'activity'=>$activity,
                        'status'=>$status_now,
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