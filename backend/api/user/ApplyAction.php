<?php

namespace backend\api\user;
use backend\models\UserCheck;
use common\base\api\CommonApiAction;
use common\exception\ApiException;
use Yii;
use yii\base\BaseObject;


class ApplyAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {


        $id=$this->RequestData('id');
        $model=UserCheck::findOne($id);
        if(!$model){
            throw new ApiException('id不正确', 1);
        }
        if($model->status==2){
            throw new ApiException('已经打卡过了', 1);
        }
        $content=$this->RequestData('content','');
        $image=$this->RequestData('image','');
        $file=$this->RequestData('file','');
        if(!$content and !$file and !$image){
            throw new ApiException('内容 图片 录音 至少提交一个', 1);
        }
        $model->content=$content;
        $model->file=$file;
        $model->image=$image;
        $model->file_time=$this->RequestData('file_time');
        $model->status=2;
        $model->check_time=time();
        if(!$model->save()){
            $errors=$model->getFirstErrors();
            throw new ApiException(reset($errors), 1);
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }
}