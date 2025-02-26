<?php

namespace backend\api\user;
use backend\models\Question;
use backend\models\Task;
use backend\models\UserIcon;
use backend\models\UserMedal;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\exception\ApiException;
use Yii;



class QuestionDeleteAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

       $id=$this->RequestData('id');
       $model=Question::findOne($id);
       if($model and $model->user_id==$this->user['id']){
           $model->delete();
       }else{
           throw new ApiException('id不正确', 1);
       }
        $jsonData['errmsg']='';
        return $jsonData;
    }
}