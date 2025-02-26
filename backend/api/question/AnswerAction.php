<?php

namespace backend\api\question;
use backend\models\Question;
use backend\models\QuestionAnswer;
use backend\models\User;
use common\base\api\CommonApiAction;
use common\exception\ApiException;
use Yii;


class AnswerAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $user_id=$this->user['id'];
        $user=User::findOne($user_id);
        $id=$this->RequestData('id');
        $model=Question::findOne($id);
        if(!$model){
            throw new ApiException('id不正确', 1);
        }
        $content=$this->RequestData('content');
        if(!$content){
            throw new ApiException('内容不能为空', 1);
        }

        if($model->user_id==$this->user['id']){
            throw new ApiException('不能回复自己', 1);
        }
        $new=new QuestionAnswer();
        $new->content=$content;
        $new->author_id=$user->id;
        $new->name=$user->name;
        $new->question_id=$id;
        $new->head_image=$user->head_image;
        $new->position=$user['position'];
        if(!$new->save()){
            throw new ApiException('提交失败', 1);
        }
        $model->answer++;
        $model->save();
        $jsonData['errmsg']='';
        return $jsonData;
    }

}