<?php

namespace backend\api\team;
use backend\models\Team;
use backend\models\User;
use backend\models\UserCheck;
use backend\models\UserTeam;
use common\base\api\CommonApiAction;
use common\components\Helper;
use common\exception\ApiException;
use Yii;
use yii\base\BaseObject;


class AddAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {


        $title=$this->RequestData('title');
        $mobile=$this->RequestData('mobile');
        $team=UserTeam::find()->where(['user_id'=>$this->user['id'],'type'=>2])->limit(1)->one();
        if($team){
            throw new ApiException('您已加入了团队', 1);
        }
        if(!$title){
            throw new ApiException('请填写团队名称', 1);
        }
        if(!$mobile){
            throw new ApiException('请填写组员', 1);
        }
        $arr=explode(',',$mobile);
        $arr=array_unique($arr);
        foreach ($arr as $k=>$v){
            $user=User::findOne(['mobile_phone'=>$v]);
            if(!$user){
                throw new ApiException($v.'这个号码用户不存在', 1);
            }
        }
        $new=new Team();
        $new->title=$title;
        $new->type=2;
        if(!$new->save()){
            throw new ApiException('创建团队失败', 1);
        }
        $old=UserTeam::findOne($new->id);
        $new2=new UserTeam();
        $new2->user_id=$this->user['id'];
        $new2->type=2;
        $new2->is_leader=1;
        $new2->user_type=3;
        $new2->team_id=$new->id;
        if(!$new2->save()){
            $old->delete();
            throw new ApiException('创建团队失败', 1);
        }
        foreach ($arr as $k=>$v){

            $user=User::findOne(['mobile_phone'=>$v]);
            $old=UserTeam::find()->where(['type'=>2,'user_id'=>$user['id']])->limit(1)->one();
            if($old){
                throw new ApiException($user->mobile_phone.'已经加入别的团队', 1);
            }
        }
        foreach ($arr as $k=>$v){

            $user=User::findOne(['mobile_phone'=>$v]);
            if($user->id==$this->user['id']){
                continue;
            }
            $new3=new UserTeam();
            $new3->user_id=$user['id'];
            $new3->type=2;
            $new3->is_leader=0;
            $new3->team_id=$new->id;
            if(!$new3->save()){
                UserTeam::deleteAll(['team_id'=>$old->id]);
                $old->delete();
                throw new ApiException('创建团队失败', 1);
            }
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }
}