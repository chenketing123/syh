<?php
namespace backend\api\common;
use backend\models\User;
use common\base\api\ApiAction;
use common\components\Helper;
use common\exception\ApiException;
use Yii;


class RegisterAction extends ApiAction
{



    public $isSign=true;
    protected function runAction()
    {


        $mobile=$this->RequestData('mobile');
        $password=$this->RequestData('password');
        $code=$this->RequestData('code');
        $re_password=$this->RequestData('re_password');
        if(!$mobile){
            throw new ApiException('请填写号码', 1);
        }
        $model=User::find()->where(['mobile_phone'=>$mobile])->limit(1)->one();
        if($model){
            throw new ApiException('该号码已注册', 1);
        }else{

            if(!$password){
                throw new ApiException('请填写密码', 1);
            }
            if($password!=$re_password){
                throw new ApiException('2次输入的密码不一致', 1);
            }

            if(!$code){
                throw new ApiException('验证码不正确', 1);
            }

            $re=Helper::checkSMS($mobile,$code);

            if($re['error']==0) {
                $new=new User();
                $new->mobile_phone=$mobile;
                $new->password=md5($password.'sdfoer');
                $new->save();
                $jsonData['token'] = $new->getToken();
                $jsonData['id'] = $new->id;
                $jsonData['name'] = $new->name;
                $jsonData['head_image'] = $new->getImg();
            }else{
                throw new ApiException($re['message'], 1);
            }


        }




        $jsonData['errmsg']='';
        return $jsonData;
    }



}