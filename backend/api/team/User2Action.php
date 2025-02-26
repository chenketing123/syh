<?php

namespace backend\api\team;
use backend\models\Team;
use backend\models\TeamDetail;
use backend\models\User;
use backend\models\UserCheck;
use backend\models\UserTeam;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\components\Helper;
use common\exception\ApiException;
use Yii;



class User2Action extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $user_id=$this->user['id'];
        $id=$this->RequestData('id');
        $user_team=UserTeam::find()->where(['type'=>2,'user_id'=>$user_id])->limit(1)->one();
        $page_number=$this->RequestData('page_number',10);
        $page=$this->RequestData('page',1);
        $begin=($page-1)*$page_number;
        if(!$user_team){
            throw new ApiException('您未加入团队', 1);
        }
        $query=UserTeam::find()->where(['team_id'=>$user_team->team_id]);
        if($id>0){
            $query->andWhere(['detail_id'=>$id]);
        }
        $model=$query->offset($begin)->limit($page_number)->orderBy('is_leader desc')->all();
        $time=strtotime(date('Y-m-d'));
        $list=[];
        foreach ($model as $k=>$v){
            $user=User::findOne($v['user_id']);
            if($user){
                $status=1;
                $old=UserCheck::find()->where(['time'=>$time,'relation_id'=>$user_team->team_id,'user_id'=>$user['id'],'status'=>2,'type'=>2])->limit(1)->one();
                if($old){
                    $status=2;
                }
                $team_title='';
                if($v['detail_id']>0){
                    $detail=TeamDetail::findOne($v['detail_id']);
                    if($detail){
                        $team_title=$detail['title'];
                    }
                }
                $list[]=[
                    'user_id'=>$user->id,
                    'name'=>$user->name,
                    'head_image'=>CommonFunction::setImg($user['head_image']),
                    'mobile'=>$user->mobile_phone,
                    'status'=>$status,
                    'team_title'=>$team_title,
                    'user_type'=>$v['user_type'],
                    'detail_id'=>$v['detail_id'],
                ];
            }

        }


        $jsonData['list']=$list;
        $jsonData['errmsg']='';
        return $jsonData;
    }
}