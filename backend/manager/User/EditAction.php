<?php

namespace backend\manager\user;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
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
        $head_portrait = $this->RequestData('head_portrait','');
        $nickname = $this->RequestData('nickname','');
        $name = $this->RequestData('name','');
        $sex = $this->RequestData('sex',0);
        $phone1 = $this->RequestData('phone1','');
        $phone2 = $this->RequestData('phone2','');
        $is_online = $this->RequestData('is_online',1);
        $is_offline = $this->RequestData('is_offline',1);
        $is_employee = $this->RequestData('is_employee',1);

        if(empty($nickname)){
            throw new ApiException('昵称不能为空',1);
        }
 
 

 

  
        $model = User::findOne($id);
        if(empty($model)){
            $model = new User();
        }
        $model->head_portrait = CommonFunction::unsetImg($head_portrait);
        $model->nickname = $nickname;
        $model->name = $name;
        $model->sex = $sex;
        $model->phone1 = $phone1;
        $model->phone2 = $phone2;
        $model->is_online = $is_online;
        $model->is_offline = $is_offline;
        $model->is_employee = $is_employee;
 
 
        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;


    }

}