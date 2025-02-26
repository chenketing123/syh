<?php

namespace backend\manager\UserArchives;

use backend\models\UserArchives;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use common\components\CommonFunction;
use backend\models\User;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class EditAction extends ManagerApiAction
{
    protected function runAction()
    {

        $id = $this->RequestData('id',0);
        $age = $this->RequestData('age',0);
        $id_number = $this->RequestData('id_number','');
        $name = $this->RequestData('name','');
        $sex = $this->RequestData('sex',0);
        $phone1 = $this->RequestData('phone1','');
        $phone2 = $this->RequestData('phone2','');
        $address = $this->RequestData('address','');
        $disease = $this->RequestData('disease',array());
        $symptoms = $this->RequestData('symptoms',array());
        $concurrent = $this->RequestData('concurrent',array());
        $course_disease = $this->RequestData('course_disease','');
        $mobile_time = $this->RequestData('mobile_time','');
        $treatment = $this->RequestData('treatment','');
        $illness_content = $this->RequestData('illness_content','');

        $model = UserArchives::find()->where(['id'=>$id])->limit(1)->one();
        if(empty($model)){
            throw new ApiException('客户档案未找到',1);
        }
        if(!is_array($disease)){
            $disease = explode('、',$disease);
        }
        if(!is_array($symptoms)){
            $symptoms = explode('、',$symptoms);
        }
        if(!is_array($concurrent)){
            $concurrent = explode('、',$concurrent);
        }
        $model->age = $age;
        $model->name = $name;
        $model->sex = $sex;
        $model->id_number = $id_number;
        $model->phone1 = $phone1;
        $model->phone2 = $phone2;
        $model->address = $address;
        $model->disease = $disease;
        $model->symptoms = $symptoms;
        $model->concurrent = $concurrent;
        $model->course_disease = $course_disease;
        $model->mobile_time = $mobile_time;
        $model->treatment = $treatment;
        $model->illness_content = $illness_content;

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;


    }

}