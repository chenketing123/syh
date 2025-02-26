<?php

namespace backend\manager\common;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class PasswordLoginAction extends ManagerApiAction
{


    public $isSign=true;
    protected function runAction()
    {
        $username = $this->RequestData('username','');
        $password = $this->RequestData('password','');

        $model = new LoginForm();
        $model->username = $username;
        $model->password = $password;

        if (!$model->login()) {
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $model = Yii::$app->user->identity;
        if($model->status!=10){
            throw new ApiException('当前账号已限制登录，请联系客服', 1);
        }

        Manager::upLoginInfo();
        $jsonData['token'] = $model->getToken();
        $jsonData['id'] = $model->id;
        $jsonData['name'] = $model->realname;
        $jsonData['role'] = $model->getRoleName();
        $jsonData['avatar'] = $model->getImg();

        return $jsonData;
    }

}