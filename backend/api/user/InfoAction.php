<?php

namespace backend\api\user;
use backend\models\Activity;
use backend\models\ActivityUser;
use backend\models\SetImage;
use backend\models\User;
use backend\models\UserApply;
use common\base\api\CommonApiAction;
use common\components\Helper;
use yii\base\BaseObject;


class InfoAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $user=User::findOne($this->user['id']);
        $jsonData['user']=User::model_message($user);
        if($jsonData['user']['is_vip']==1){
            $jsonData['user']['remaining']=ceil((strtotime($jsonData['user']['end_time'])+24*3600-time())/(24*3600));
            $jsonData['user']['apply_status']=2;
        }else{
            $jsonData['user']['remaining']=0;
            $is_apply=0;
            $apply=UserApply::find()->where(['user_id'=>$this->user['id']])->limit(1)->one();
            if($apply){
                $is_apply=1;
            }
            $jsonData['user']['apply_status']=$is_apply;
        }

        $jsonData['user']['unread_number']=0;
        $model2=SetImage::find()->where(['or',['type'=>2],['and',['type'=>99],['user_id'=>$this->user['id']]]])->all();
        foreach ($model2 as $k=>$v){
            if($v['type']==2){
                $old=SetImage::find()->where(['type'=>98,'user_id'=>$this->user['id'],'realtion_id'=>$v['id']])->limit(1)->one();
                if(!$old){
                    $jsonData['user']['unread_number']++;
                }
            }else{
                if($v['is_read']==0){
                    $jsonData['user']['unread_number']++;
                }
            }
        }

        $activity_user=ActivityUser::find()->where(['pay_status'=>2,'user_id'=>$this->user['id']])->all();
        foreach ($activity_user as $k=>$v){
            $activity=Activity::findOne($v['activity_id']);
            if(($activity->start_time-4*24*3600)<=time() and $activity->end_time>=time()){
                $old=SetImage::find()->where(['type'=>99,'realtion_id'=>$activity->id,'user_id'=>$this->user['id']])->limit(1)->one();
                if(!$old){
                    $new=new SetImage();
                    $new->type=99;
                    $new->user_id=$this->user['id'];
                    $new->realtion_id=$activity->id;
                    $new->info='您的活动将于'.date('Y-m-d H:i',$activity->start_time).'开始';
                    $new->save();
                }
            }
        }



        $jsonData['errmsg']='';
        return $jsonData;
    }



}