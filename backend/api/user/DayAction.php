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



class DayAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $time=strtotime($this->RequestData('time',date('Y-m-d')));
        $type=$this->RequestData('type','');
        $user_id=$this->RequestData('user_id');
        if(!$user_id){
            $user_id=$this->user['id'];
        }
        $model=UserCheck::find()->where(['user_id'=>$user_id,'time'=>$time])->andFilterWhere(['type'=>$type])->all();
        $jsonData['list']=[];
        $jsonData['activity']=[];
        $activity=Activity::find()->where(['<=','start_time',($time+24*3600-1)])->andWhere(['>=','end_time',$time])->orderBy('sort asc,id desc')->all();
        foreach ($activity as $k=>$v){
            $jsonData['activity'][]=[
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
        foreach ($model as $k=>$v){
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
//                $title=$book->title;
//                if($detail['number1']>0){
//                    $title.='第'.$detail['number1'].'章';
//                }
//                if($detail['number2']>0){
//                    $title.='第'.$detail['number2'].'节';
//                }
                $title=$detail['title'];
                $jsonData['list'][]=[
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

        $jsonData['errmsg']='';
        return $jsonData;
    }
}