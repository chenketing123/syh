<?php

namespace backend\api\message;
use backend\models\Message;
use backend\models\User;
use backend\models\UserMessage;
use common\base\api\CommonApiAction;
use common\exception\ApiException;
use Yii;


class AddAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $company=$this->RequestData('company');
        if(!$company){
            throw new ApiException('请填写公司名称', 1);
        }
        $number=$this->RequestData('number');
        if(!$company){
            throw new ApiException('请填写员工人数', 1);
        }
        $money=$this->RequestData('money');
        if(!$money){
            throw new ApiException('请填写产值', 1);
        }
        $scale=$this->RequestData('scale');
        if(!$scale){
            throw new ApiException('请填写规模', 1);
        }
        $id=$this->RequestData('id');
        $user_id=$this->user['id'];
        $new=new UserMessage();
        $new->message_id=$id;
        $new->user_id=$user_id;
        $new->scale=$scale;
        $new->company=$company;
        $new->number=$number;
        $new->money=$money;
        if(!$new->save()){
            $errors=$new->getFirstErrors();
            throw new ApiException(reset($errors), 1);
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }

}