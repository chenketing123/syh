<?php

namespace backend\api\user;
use backend\models\Activity;
use backend\models\ActivityUser;
use backend\models\Question;
use backend\models\SetImage;
use backend\models\Task;
use backend\models\UserIcon;
use backend\models\UserMedal;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\components\Helper;
use Yii;



class MessageAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {




        $page_number=$this->RequestData('page_number',10);
        $page=$this->RequestData('page',1);
        $begin=($page-1)*$page_number;

        $query=SetImage::find()->where(['or',['type'=>2],['and',['type'=>99],['user_id'=>$this->user['id']]]]);
        $jsonData['total_pages']=ceil($query->count()/$page_number);
        $jsonData['total_count']=$query->count()*1;
        $model=$query->orderBy('id desc')->offset($begin)->limit($page_number)->all();
        $jsonData['list']=[];
        $jsonData['unread_number']=0;
        $model2=SetImage::find()->where(['or',['type'=>2],['and',['type'=>99],['user_id'=>$this->user['id']]]])->all();
        foreach ($model2 as $k=>$v){
            if($v['type']==2){
                $old=SetImage::find()->where(['type'=>98,'user_id'=>$this->user['id'],'realtion_id'=>$v['id']])->limit(1)->one();
                if(!$old){
                    $jsonData['unread_number']++;
                }
            }else{
                if($v['is_read']==0){
                    $jsonData['unread_number']++;
                }
            }
        }
        foreach ($model as $k=>$v){

            if($v['type']==2){
                $type='系统消息';
                $old=SetImage::find()->where(['type'=>98,'user_id'=>$this->user['id'],'realtion_id'=>$v['id']])->limit(1)->one();
                if($old){
                    $is_read=1;
                }else{
                    $is_read=0;
                }
            }else{
                $type='活动提醒';
                $is_read=$v['is_read'];
            }
            $jsonData['list'][]=[
                'id'=>$v['id'],
                'title'=>$v['title'],
                'type'=>$type,
                'info'=>Helper::truncate_utf8_string($v['info'],100),
                'time'=>date('Y年m月d日',$v['created_at']),
                'is_read'=>$is_read,

            ];
        }

        $jsonData['errmsg']='';

        return $jsonData;
    }
}