<?php

namespace backend\manager\Market;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use backend\models\Market;


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

        $model = Market::find()->where(['id'=>$id])->asArray()->limit(1)->one();
        if(empty($model)){
            throw new ApiException('连锁归属未找到',1);
        }
 
        $model['province_string'] = \backend\models\Provinces::getName2($model['province']);


        $jsonData['model'] = $model;
 
        return $jsonData;
    }

}