<?php

namespace backend\api\user;
use backend\models\UserCheck;
use backend\models\UserTeam;
use common\base\api\CommonApiAction;
use Yii;


class TaskAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {



        $user_id=$this->user['id'];
        $time=strtotime(date('Y-m-01'));
        $count=UserCheck::find()->where(['user_id'=>$user_id])->andWhere(['<=','time',$time])->groupBy('time')->count()*1;
        $count1=UserCheck::find()->where(['user_id'=>$user_id,'status'=>2])->andWhere(['<=','time',$time])->groupBy('time')->count()*1;
        if($count>0){
            $number=round($count1/$count,3)*100;
        }else{
            $number=0;
        }
        $jsonData['user']=[
            'number1'=>$count1,
            'number2'=>$number,
        ];
        $jsonData['team']=[];
        $jsonData['group']=[];
        $team=UserTeam::find()->where(['user_id'=>$user_id,'type'=>1])->limit(1)->one();
        if($team){
            $total_number=UserTeam::find()->where(['team_id'=>$team['team_id'],'type'=>1])->count()*1;
            $team_number=0;
            $user1=[];
            $model1=UserCheck::find()->where(['relation_id'=>$team->team_id])->andWhere(['<=','time',$time])->all();
            foreach ($model1 as $k=>$v){
                if(!in_array($v['user_id'],$user1) and $v['status']==2){
                    $user1[]=$v['user_id'];
                    $team_number++;
                }

            }
            if($total_number>0){
                $number2=round($team_number/$total_number,3)*100;
            }
            $jsonData['team']=[

                'total_number'=>$total_number,
                'number1'=>$team_number,
                'number2'=>$number2,
            ];

        }

        $group=UserTeam::find()->where(['user_id'=>$user_id,'type'=>2])->limit(1)->one();
        if($group){
            $total_number=UserTeam::find()->where(['team_id'=>$group['team_id'],'type'=>2])->count()*1;
            $team_number=0;
            $user1=[];
            $model1=UserCheck::find()->where(['relation_id'=>$group->team_id])->andWhere(['<=','time',$time])->all();
            foreach ($model1 as $k=>$v){
                if(!in_array($v['user_id'],$user1) and $v['status']==2){
                    $user1[]=$v['user_id'];
                    $team_number++;
                }

            }
            if($total_number>0){
                $number2=round($team_number/$total_number,3)*100;
            }
            $jsonData['group']=[

                'total_number'=>$total_number,
                'number1'=>$team_number,
                'number2'=>$number2,
            ];

        }
        if(count($jsonData['team'])<=0){
            $jsonData['team']="";
        }
        if(count($jsonData['group'])<=0){
            $jsonData['group']="";
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }
}