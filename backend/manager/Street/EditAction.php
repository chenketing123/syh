<?php

namespace backend\manager\Street;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\Street;


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
        $name = $this->RequestData('name','');
        $province = $this->RequestData('province',0);
        $city = $this->RequestData('city',0);
        $district = $this->RequestData('district',0);


        if(empty($name)){
            throw new ApiException('街道名称不能为空',1);
        }
        if(empty($province)){
            throw new ApiException('省份不能为空',1);
        }
        if(empty($city)){
            throw new ApiException('城市不能为空',1);
        }
        if(empty($district)){
            throw new ApiException('地区不能为空',1);
        }

 
  
        $model = Street::findOne($id);
        if(empty($model)){
            $model = new Street();
        }
        $model->name = $name;
        $model->province = $province;
        $model->city = $city;
        $model->district = $district;
 
 
 

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;


    }

}