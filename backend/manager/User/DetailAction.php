<?php

namespace backend\manager\user;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use backend\models\User;


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

        $user = User::find()->where(['id'=>$id])->limit(1)->one();
        if(empty($user)){
            throw new ApiException('用户未找到',1);
        }



        $model = array();

        $model['id'] = $user['id'];
        $model['head_portrait'] = $user->getImg();
        $model['nickname'] = $user['nickname'];
        $model['name'] = $user['name'];
        $model['sex'] = $user['sex'];
        $model['phone1'] = $user['phone1'] ? $user['phone1'] : '';
        $model['phone2'] = $user['phone2'] ? $user['phone2'] : '';
        $model['is_online'] = $user['is_online'];
        $model['is_offline'] = $user['is_offline'];
        $model['is_employee'] = $user['is_employee'];
 
            

        

        $jsonData['model'] = $model;
 
        return $jsonData;
    }

}