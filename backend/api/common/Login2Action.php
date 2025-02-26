<?php
namespace backend\api\common;
use backend\models\User;
use common\base\api\ApiAction;
use common\exception\ApiException;
use Yii;


class Login2Action extends ApiAction
{


    public $isSign=true;
    protected function runAction()
    {
        $mobile=$this->RequestData('mobile');
        $code=$this->RequestData('code');
        $model=User::find()->where(['mobile_phone'=>$mobile])->limit(1)->one();
        if(!$model){
            throw new ApiException('该号码未注册', 1);
        }else{
            $jsonData['token'] = $model->getToken();
            $jsonData['id'] = $model->id;
            $jsonData['name'] = $model->name;
            //$jsonData['role'] = EmployeeRole::getName($model->role_id);
            $jsonData['head_image'] = $model->getImg();
        }




        $jsonData['errmsg']='';
        return $jsonData;
    }



}