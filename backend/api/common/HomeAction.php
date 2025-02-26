<?php

namespace backend\api\common;
use backend\models\Activity;
use backend\models\ActivityUser;
use backend\models\SetImage;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\components\Helper;
use Yii;


class HomeAction extends CommonApiAction
{
//    public $isSign=true;
//    public $isLogin=true;

    protected function runAction()
    {



        $banner=SetImage::getList(['type'=>1]);
        $data_banner=[];
        foreach ($banner as $k=>$v){
            $data_banner[]=[
                'image'=>CommonFunction::setImg($v['image'])
            ];
        }
        $data_activity=[];
        $activity=Activity::find()->where(['is_index'=>1])->orderBy('sort asc,id desc')->all();
        foreach ($activity as $k=>$v){
            if($v['price']==0){
                $v['price']='公益免费';
            }
            $data_activity[]=[
                'id'=>$v['id'],
                'title'=>$v['title'],
                'start_time'=>date('m-d H:i',$v['start_time']),
                'end_time'=>date('m-d H:i',$v['end_time']),
                'image'=>CommonFunction::setImg($v['image']),
                'number'=>$v['number'],
                'status'=>$v['status'],
                'address'=>$v['address'],
                'price'=>$v['price'],
                'now_number'=>ActivityUser::find()->where(['activity_id'=>$v['id']])->count()*1,
            ];
        }

        $message_data=[];
        if(isset($this->user)){
            $message=SetImage::find()->where(['or',['type'=>2],['and',['type'=>99],['user_id'=>$this->user['id']]]])->orderBy('created_at desc')->limit(10)->all();
            foreach ($message as $k=>$v){
                if($v['type']==2){
                    $type='系统消息';
                }else{
                    $type='活动提醒';
                }
                $message_data[]=[
                    'title'=>$v['title'],
                    'info'=>Helper::imageUrl($v['info'],Yii::$app->request->hostInfo),
                    'type'=>$type,
                    'time'=>date('Y年m月d日',$v['created_at']),
                ];
            }
        }else{
            $message=SetImage::getList(['type'=>2]);
            foreach ($message as $k=>$v){
                $message_data[]=[
                    'title'=>$v['title'],
                    'type'=>'系统消息',
                    'info'=>Helper::imageUrl($v['info'],Yii::$app->request->hostInfo),
                    'time'=>date('Y年m月d日',$v['created_at']),
                ];
            }
        }





        $jsonData['data']=[
            'banner'=>$data_banner,
            'message'=>$message_data,
            'activity'=>$data_activity,

        ];

        $jsonData['errmsg']='';
        return $jsonData;
    }

}