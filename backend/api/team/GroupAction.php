<?php

namespace backend\api\team;
use backend\models\Team;
use backend\models\TeamDetail;
use backend\models\User;
use backend\models\UserCheck;
use backend\models\UserTeam;
use common\base\api\CommonApiAction;
use common\components\Helper;
use common\exception\ApiException;
use Yii;



class GroupAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $user_id=$this->user['id'];
        $user_team=UserTeam::find()->where(['type'=>2,'user_id'=>$user_id])->limit(1)->one();
        if(!$user_team){
            throw new ApiException('您未加入团队', 1);
        }
        $team=Team::findOne($user_team->team_id);
        $time=strtotime(date('Y-m-d'));
        $total_number=UserTeam::find()->where(['team_id'=>$user_team->team_id])->count()*1;
        $read_number=UserCheck::find()->where(['relation_id'=>$user_team->team_id,'status'=>2,'time'=>$time])->groupBy('user_id')->count()*1;
        $unread_number=$total_number-$read_number;
        $detail=TeamDetail::find()->where(['team_id'=>$user_team->team_id])->all();
        $list=[];
        foreach ($detail as $k=>$v){
            $number1=UserTeam::find()->where(['detail_id'=>$v['id']])->count()*1;
            $model=UserTeam::find()->where(['detail_id'=>$v['id']])->all();
            $arr_user=[];
            foreach ($model as $k2=>$v2){
                $arr_user[]=$v2['user_id'];
            }
            $number2=UserCheck::find()->where(['relation_id'=>$user_team->team_id,'status'=>2,'time'=>$time])->andWhere(['in','user_id',$arr_user])->groupBy('user_id')->count()*1;
            $list[]=[
                'id'=>$v['id'],
                'title'=>$v['title'],
                'total_number'=>$number1,
                'read_number'=>$number2,
            ];
        }
        $jsonData['total_number']=$total_number;
        $jsonData['read_number']=$read_number;
        $jsonData['unread_number']=$unread_number;
        $jsonData['team_title']=$team['title'];
        $jsonData['list']=$list;
        $jsonData['errmsg']='';
        return $jsonData;
    }
}