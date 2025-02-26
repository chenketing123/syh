<?php

namespace backend\manager\manager;

use backend\models\Manager;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\components\CommonFunction;
use common\exception\ApiException;
use Yii;

/**
 * @Class SaveAction
 * @package backend\manager\note
 * @User:五更的猫
 * @DateTime: 2023/12/13 16:25
 * @TODO 新增修改管理员
 */
class SaveAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $id = $this->RequestData('id',null);
        $username = $this->RequestData('username','');
        $realname = $this->RequestData('realname','');
        $head_portrait = $this->RequestData('head_portrait','');
        $sex = $this->RequestData('sex',0);
        $email = $this->RequestData('email','');
        $birthday = $this->RequestData('birthday','');
        $address = $this->RequestData('address','');
        $provinces = $this->RequestData('provinces',0);
        $city = $this->RequestData('city',0);
        $area = $this->RequestData('area',0);
        $mobile_phone = $this->RequestData('mobile_phone','');
        $role_id = $this->RequestData('role_id',0);
        $password_hash = $this->RequestData('password_hash','');

        if(empty($username)){
            throw new ApiException('请填写登录名',1);
        }
        if(!empty($password_hash)) {
            if(strlen($password_hash)<6){
                throw new ApiException('登录密码最少需6位',1);
            }
        }
        if(!empty($id)){
            $model = Manager::findOne(['id'=>$id]);
            if(empty($model)){
                throw new ApiException('未找到此管理员账号',1);
            }
        }else{
            $model = new Manager();
            if(empty($password_hash)){
                throw new ApiException('请填写登录密码',1);
            }
        }
        $model->username = $username;
        $model->realname = $realname;
        $model->head_portrait = CommonFunction::unsetImg($head_portrait);
        $model->sex = $sex;
        $model->email = $email;
        $model->birthday = $birthday;
        $model->address = $address;
        $model->provinces = (string)$provinces;
        $model->city = (string)$city;
        $model->area = (string)$area;
        $model->mobile_phone = $mobile_phone;
        $model->role_id = $role_id;
        if(!empty($password_hash)) {
            $model->password_hash = $password_hash;
        }

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id']=$model->id;

        return $jsonData;
    }

}