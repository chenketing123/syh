<?php

namespace backend\manager\LiveActivity;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use backend\models\LiveActivity;


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

        $model = LiveActivity::find()->where(['id'=>$id])->limit(1)->asArray()->one();
        if(empty($model)){
            throw new ApiException('直播活动未找到',1);
        }
 
        $model['room_title'] = \backend\models\LiveRoom::getName($model['room_id']);

 

        $jsonData['model'] = $model;
 
        return $jsonData;
    }

}