<?php

namespace backend\api\team;
use backend\models\Team;
use backend\models\User;
use backend\models\UserCheck;
use backend\models\UserTeam;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\components\Helper;
use Yii;



class ListAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $jsonData['team']=[
            'list'=>[],
            'name'=>'',
            'read_number'=>0,
            'is_leader'=>0,
        ];
        $jsonData['group']=[
            'list'=>[],
            'name'=>'',
            'read_number'=>0,
            'is_leader'=>0,
        ];
        $team1=UserTeam::find()->where(['user_id'=>$this->user['id'],'type'=>1])->limit(1)->one();
        if($team1){
            if($team1['user_type']==2 or $team1['user_type']==3){
                $jsonData['team']['is_leader']=1;
            }
        }
        $team2=UserTeam::find()->where(['user_id'=>$this->user['id'],'type'=>2])->limit(1)->one();
        if($team2){
            if($team2['user_type']==2 or $team2['user_type']==3){
                $jsonData['group']['is_leader']=1;
            }

        }
        $time=strtotime(date('Y-m-d'));
        $model=UserTeam::find()->where(['user_id'=>$this->user['id']])->groupBy('team_id')->all();
        foreach ($model as $k=>$v){
            if($v['type']==1){
                $team=Team::findOne($v['team_id']);
                if($team){
                    $read_number=UserCheck::find()->where(['type'=>1,'relation_id'=>$v['team_id'],'time'=>$time,'status'=>2])->groupBy('user_id')->count()*1;
                    $jsonData['team']['name']=$team['title'];
                    $jsonData['team']['read_number']=$read_number;
                    $list=UserTeam::find()->where(['type'=>1,'team_id'=>$v['team_id']])->all();
                    foreach ($list as $k2=>$v2){
                        if($k2<=9){
                            $user=User::findOne($v2['user_id']);
                            if($user){
                                $jsonData['team']['list'][]=[
                                    'name'=>$user['name'],
                                    'head_image'=>CommonFunction::setImg($user['head_image']),
                                ];
                            }
                        }


                    }
                }

            }
            elseif($v['type']==2){
                $list=UserTeam::find()->where(['type'=>2,'team_id'=>$v['team_id']])->limit(6)->all();
                $team=Team::findOne($v['team_id']);
                if($team) {
                    $jsonData['group']['name']=$team['title'];
                    $read_number=UserCheck::find()->where(['type'=>2,'relation_id'=>$v['team_id'],'time'=>$time,'status'=>2])->groupBy('user_id')->count()*1;
                    $jsonData['group']['read_number']=$read_number;
                    foreach ($list as $k2 => $v2) {
                        if($k2<=9) {
                            $user = User::findOne($v2['user_id']);
                            if ($user) {
                                $jsonData['group']['list'][] = [
                                    'name' => $user['name'],
                                    'head_image' => CommonFunction::setImg($user['head_image']),
                                ];
                            }
                        }

                    }
                }
            }
        }


        $jsonData['errmsg']='';
        return $jsonData;
    }
}