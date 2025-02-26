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
use yii\base\BaseObject;


class UpdateUserAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {


        $mobile=$this->RequestData('mobile');
        $detail_id=$this->RequestData('detail_id');
        $user_type=$this->RequestData('user_type',1);
        $user=User::findOne(['mobile_phone'=>$mobile]);
        if(!$user){
            throw new ApiException('这个号码用户不存在', 1);
        }
        $detail=TeamDetail::findOne($detail_id);
        if(!$detail){
            throw new ApiException('小组id不正确', 1);
        }

        $user_team=UserTeam::find()->where(['user_id'=>$user['id'],'type'=>2])->limit(1)->one();
        if($user_team){
            $user_team->detail_id=$detail_id;
            $user_team->user_type=$user_type;
            if(!$user_team->save()){
                throw new ApiException('保存失败', 1);
            }
        }else{
            $old=UserTeam::find()->where(['type'=>2,'user_id'=>$user['id']])->limit(1)->one();
            if($old){
                throw new ApiException($user->mobile_phone.'已经加入别的团队', 1);
            }
            $new=new UserTeam();
            $new->team_id=$detail['team_id'];
            $new->type=2;
            $new->detail_id=$detail_id;
            $new->user_id=$user['id'];
            if(!$new->save()){
                throw new ApiException('保存失败', 1);
            }
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }
}