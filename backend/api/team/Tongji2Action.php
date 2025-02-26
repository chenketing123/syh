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



class Tongji2Action extends CommonApiAction
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
        if($user_team->user_type==1){
            throw new ApiException('您没有该权限', 1);
        }
        $team_detail=TeamDetail::find()->where(['team_id'=>$user_team->team_id])->all();
        $page_number=$this->RequestData('page_number',10);
        $page=$this->RequestData('page',1);
        $begin=($page-1)*$page_number;
        $detail_id=$this->RequestData('detail_id','');
        $query=UserTeam::find()->where(['team_id'=>$user_team->team_id])->andFilterWhere(['detail_id'=>$detail_id]);
        $start_time=$this->RequestData('start_time','');
        $end_time=$this->RequestData('end_time','');
        $jsonData['total_pages']=ceil($query->count()/$page_number);
        $jsonData['total_count']=$query->count()*1;
        $jsonData['list']=[];
        $team=Team::findOne($user_team['team_id']);
        $jsonData['team_name']=$team['title'];
        $jsonData['team_detail']=[];
        foreach ($team_detail as $k=>$v){
            $jsonData['team_detail'][]=[
                'detail_id'=>$v['id'],
                'title'=>$v['title'],
            ];
        }
        $model=$query->orderBy('user_type desc,sort asc,id desc')->offset($begin)->limit($page_number)->all();
        foreach ($model as $k=>$v){
            $user=User::findOne($v['user_id']);
            if($user){
                $detail_title='';
                if($v->detail_id>0){
                    $detail=TeamDetail::findOne($v['detail_id']);
                    if($detail){
                        $detail_title=$detail->title;
                    }
                }
                if($start_time and $end_time){
                    $start=strtotime($start_time);
                    $end=strtotime($end_time)+24*3600-1;
                    $number=UserCheck::find()->where(['relation_id'=>$v['team_id'],'user_id'=>$v['user_id'],'status'=>2])->andWhere(['>=','time',$start])
                        ->andWhere(['<=','time',$end])->count();
                }else{
                    $number=UserCheck::find()->where(['relation_id'=>$v['team_id'],'user_id'=>$v['user_id'],'status'=>2])->count();
                }
                $jsonData['list'][]=[
                    'user_id'=>$user['id'],
                    'user_name'=>$user['name'],
                    'user_type'=>$v['user_type'],
                    'head_image'=>CommonFunction::setImg($user['head_image']),
                    'number'=>$number,
                    'mobile'=>$user['mobile_phone'],
                    'detail_title'=>$detail_title
                ];
            }

        }
        $jsonData['errmsg']='';
        return $jsonData;
    }
}