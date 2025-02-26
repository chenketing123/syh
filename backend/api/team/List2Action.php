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



class List2Action extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $user_id=$this->user['id'];
        $user_team=UserTeam::find()->where(['type'=>1,'user_id'=>$user_id])->limit(1)->one();
        if(!$user_team){
            throw new ApiException('您未加入小组', 1);
        }
        $detail=TeamDetail::find()->where(['team_id'=>$user_team->team_id])->all();
        $list=[];
        foreach ($detail as $k=>$v){

            $list[]=[
                'id'=>$v['id'],
                'title'=>$v['title'],
            ];
        }
        $jsonData['list']=$list;
        $jsonData['errmsg']='';
        return $jsonData;
    }
}