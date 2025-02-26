<?php

namespace backend\manager\Goods;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use backend\models\Goods;


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

        $model = Goods::find()->where(['id'=>$id])->asArray()->limit(1)->one();
        if(empty($model)){
            throw new ApiException('产品未找到',1);
        }
 
        

        $jsonData['model'] = $model;
 
        return $jsonData;
    }

}