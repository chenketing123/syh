<?php

namespace backend\manager\Street;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use backend\models\Street;
use backend\models\Provinces;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class DetailAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $id = $this->RequestData('id',0);

        $model = Street::find()->where(['id'=>$id])->limit(1)->asArray()->one();
        if(empty($model)){
            throw new ApiException('街道未找到',1);
        }
 
        $model['province_string'] = Provinces::getName2($model['province']);
        $model['city_string'] = Provinces::getName2($model['city']);
        $model['district_string'] = Provinces::getName2($model['district']);


 

        $jsonData['model'] = $model;
 
        return $jsonData;
    }

}