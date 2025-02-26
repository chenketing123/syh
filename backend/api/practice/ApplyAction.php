<?php

namespace backend\api\practice;
use backend\models\Practice;
use backend\models\PracticeUser;
use backend\models\Task;
use backend\models\TaskUser;
use backend\models\User;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\components\Helper;
use common\exception\ApiException;
use Yii;
use yii\base\BaseObject;


class ApplyAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $id = $this->RequestData('id');
        $model = Practice::findOne($id);
        if (!$model) {
            throw new ApiException('id不正确', 1);
        }
        $old=PracticeUser::find()->where(['practice_id'=>$id,'user_id'=>$this->user['id']])->limit(1)->one();
        if($old){
            throw new ApiException('您已打卡', 1);
        }else{
            $content=$this->RequestData('content','');
            $image=$this->RequestData('image','');
            $file=$this->RequestData('file','');
            if(!$content){
                throw new ApiException('请填写内容', 1);
            }
            $new=new PracticeUser();
            $new->user_id=$this->user['id'];
            $new->content=$content;
            $new->file=$file;
            $new->image=$image;
            $new->practice_id=$id;
            $new->file_time=$this->RequestData('file_time');
            if(!$new->save()){
                $errors=$new->getFirstErrors();
                throw new ApiException(reset($errors), 1);
            }
        }

        $jsonData['errmsg'] = '';
        return $jsonData;
    }

}