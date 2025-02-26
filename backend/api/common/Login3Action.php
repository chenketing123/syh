<?php
namespace backend\api\common;
use backend\models\User;
use common\base\api\ApiAction;
use common\exception\ApiException;
use Yii;



class Login3Action extends ApiAction
{

    public $isSign=true;
    protected function runAction()
    {
        $mobile=$this->RequestData('mobile');
        $model=User::find()->where(['mobile_phone'=>$mobile])->limit(1)->one();
        if(!$mobile){
            throw new ApiException('电话号码为空', 1);
        }
        if(!$model){
            $new=new User();
            $new->mobile_phone=$mobile;
            $new->password=md5('123456sdfoer');
            $new->save();
            $jsonData['token'] = $new->getToken();
            $jsonData['id'] = $new->id;
            $jsonData['name'] = $new->name;
            $jsonData['head_image'] = $new->getImg();
            $jsonData['type']=2;
        }else{
            $jsonData['token'] = $model->getToken();
            $jsonData['id'] = $model->id;
            $jsonData['name'] = $model->name;
            //$jsonData['role'] = EmployeeRole::getName($model->role_id);
            $jsonData['head_image'] = $model->getImg();
            $jsonData['type']=1;
        }




        $jsonData['errmsg']='';
        return $jsonData;
    }



}