<?php

namespace backend\api\team;
use backend\models\TeamDetail;
use backend\models\UserTeam;
use common\base\api\CommonApiAction;
use common\exception\ApiException;
use Yii;
use yii\base\BaseObject;


class UpdateAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {


        $user_team=UserTeam::find()->where(['user_id'=>$this->user['id'],'type'=>2])->limit(1)->one();
        if($user_team){
            if($user_team->is_leader==0){
                throw new ApiException('您不是团长', 1);
            }
        }else{
            throw new ApiException('您没有团队', 1);
        }
        $list=$this->RequestData('list');
        if(!$list){
            throw new ApiException('请提交数据', 1);
        }
        $arr=json_decode($list,true);
        $arr2=[];
        $detail=TeamDetail::find()->where(['team_id'=>$user_team->team_id])->all();
        foreach ($arr as $k=>$v){
            if($v['id']>0){
                $arr2[]=$v['id'];
            }
        }
        if(count($arr2)==0){
            TeamDetail::deleteAll(['team_id'=>$user_team->team_id]);
        }else{
            foreach ($detail as $k=>$v){
                if(!in_array($v['id'],$arr2)){
                    $v->delete();
                }
            }
        }
        foreach ($arr as $k=>$v){
            if($v['id']==0){
                $new=new TeamDetail();
                $new->title=$v['title'];
                $new->team_id=$user_team->team_id;
                $new->save();
            }else{
                $model=TeamDetail::findOne($v['id']);
                if($model){
                    $model->title=$v['title'];
                    $model->save();
                }
            }
        }


        $jsonData['errmsg']='';
        return $jsonData;
    }
}