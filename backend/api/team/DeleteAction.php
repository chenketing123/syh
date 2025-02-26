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



class DeleteAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $user_id=$this->RequestData('user_id');

        $user=User::findOne($user_id);
        if(!$user){
            throw new ApiException('user_id不正确', 1);
        }
        $team=UserTeam::find()->where(['user_id'=>$this->user['id'],'type'=>2])->limit(1)->one();
        if(!$team){
            throw new ApiException('您未加入团队', 1);
        }
        if($team->is_leader!=1){
            throw new ApiException('您不是团长', 1);
        }
        $team2=UserTeam::find()->where(['user_id'=>$user['id'],'type'=>2])->limit(1)->one();
        if(!$team2){
            throw new ApiException('该成员未加入您的团队', 1);
        }else{
            $team2->delete();
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }
}