<?php

namespace backend\api\question;
use backend\models\Like;
use backend\models\Question;
use common\base\api\CommonApiAction;
use common\exception\ApiException;
use Yii;


class LikeAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $id=$this->RequestData('id');
        $model=Question::findOne($id);
        if(!$model){
            throw new ApiException('id不正确', 1);
        }

        $old=Like::find()->where(['type'=>1,'question_id'=>$id,'user_id'=>$this->user['id']])->limit(1)->one();
        if($old){
           $old->delete();
           $model->like--;
            $jsonData['status']=2;
        }else{
            $new=new Like();
            $new->question_id=$id;
            $new->user_id=$this->user['id'];
            $new->type=1;
            if(!$new->save()){
                throw new ApiException('失败', 1);
            }

            $model->like++;
            $jsonData['status']=1;
        }

        $model->save();
        $jsonData['errmsg']='';
        return $jsonData;
    }

}