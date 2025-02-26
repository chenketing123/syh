<?php

namespace backend\api\activity;
use backend\models\Activity;
use backend\models\ActivityUser;
use backend\models\User;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\components\Helper;
use common\exception\ApiException;
use Yii;


class CheckMessageAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {
        $id = $this->RequestData('id');
        $model = Activity::findOne($id);
        if (!$model) {
            throw new ApiException('id不正确', 1);
        }
        $old=ActivityUser::find()->where(['activity_id'=>$id,'user_id'=>$this->user['id'],'pay_status'=>2])->limit(1)->one();
        if($old){
            $jsonData['status']=2;
        }else{
            $jsonData['status']=1;
        }

        $jsonData['errmsg'] = '';
        return $jsonData;
    }

}