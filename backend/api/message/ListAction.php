<?php

namespace backend\api\message;
use backend\models\Message;
use backend\models\UserMessage;
use common\base\api\CommonApiAction;
use Yii;


class ListAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {
        $page_number=$this->RequestData('page_number',10);
        $page=$this->RequestData('page',1);
        $begin=($page-1)*$page_number;
        $query=Message::find();
        $jsonData['total_pages']=ceil($query->count()/$page_number);
        $jsonData['total_count']=$query->count()*1;
        $model=$query->orderBy('sort asc,id desc')->offset($begin)->limit($page_number)->all();
        $jsonData['list']=[];
        foreach ($model as $k=>$v){
            $status=1;
            $old=UserMessage::find()->where(['user_id'=>$this->user['id'],'message_id'=>$v['id']])->limit(1)->one();
            if($old){
                $status=2;
            }
            $jsonData['list'][]=[
                'id'=>$v['id'],
                'title'=>$v['title'],
                'status'=>$status,
                'type'=>$v['type'],
                'path'=>'/'.$v['path'],
                'appid'=>'wx34b0738d0eef5f78',

            ];
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }

}