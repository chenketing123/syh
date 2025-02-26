<?php

namespace backend\manager\ActivityApply;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\ActivityApply;


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
        $terminal_id = $this->RequestData('terminal_id',0);
        $phone = $this->RequestData('phone','');
        $name = $this->RequestData('name','');
        $sex = $this->RequestData('sex',1);
        $id_number = $this->RequestData('id_number','');
        $province = $this->RequestData('province',0);
        $city = $this->RequestData('city',0);
        $district = $this->RequestData('district',0);
        $address = $this->RequestData('address','');
        $type = $this->RequestData('type','');
        $price = $this->RequestData('price',0);
        $referral_number = $this->RequestData('referral_number',0);
        $referral_price = $this->RequestData('referral_price',0);
        $remark = $this->RequestData('remark','');
        $images = $this->RequestData('images',array());
        $tohoro_name = $this->RequestData('tohoro_name','');
        $h = $this->RequestData('h','');
        $wuxiao = $this->RequestData('wuxiao','');
 

 

        $model = ActivityApply::findOne($id);

        if(empty($model)){
            throw new ApiException('报名记录未找到',1);
        }

        if(!empty($images) && !is_array($images)){
            $images = explode(',',$images);
        }

        foreach($images as $k => $v){
            $images[$k] = CommonFunction::unsetImg($v);
        }

        $model->terminal_id = $terminal_id;
        $model->phone = $phone;
        $model->name = $name;
        $model->sex = $sex;
        $model->id_number = $id_number;
        $model->province = $province;
        $model->city = $city;
        $model->district = $district;
        $model->address = $address;
        $model->type = $type;
        $model->price = $price;
        $model->referral_number = $referral_number;
        $model->referral_price = $referral_price;
        $model->remark = $remark;
        $model->images = $images;
        $model->tohoro_name = $tohoro_name;
        $model->h = $h;
        $model->wuxiao = $wuxiao;

 

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;


    }

}