<?php

namespace backend\manager\UserArchives;

use backend\models\LoginForm;
use backend\models\Manager;
use backend\models\UserArchives;
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

        $user = UserArchives::find()->where(['id'=>$id])->limit(1)->one();
        if(empty($user)){
            throw new ApiException('客户档案未找到',1);
        }

        $model = array();

        $model['id'] = $user['id'];
        $model['name'] = (string)$user['name'];
        $model['sex'] = (string)$user['sex'];
        $model['age'] = (string)$user['age'];
        $model['id_number'] = (string)$user['id_number'];
        $model['address'] = (string)$user['address'];

        $model['phone1'] = $user['phone1'] ? $user['phone1'] : '';
        $model['phone2'] = $user['phone2'] ? $user['phone2'] : '';

        $model['disease'] = (string)$user['disease'];
        $model['symptoms'] = (string)$user['symptoms'];
        $model['concurrent'] = (string)$user['concurrent'];

        $model['disease_arr'] = empty($user['disease'])?array():explode('、',$user['disease']);
        $model['symptoms_arr'] = empty($user['symptoms'])?array():explode('、',$user['symptoms']);
        $model['concurrent_arr'] = empty($user['concurrent'])?array():explode('、',$user['concurrent']);

        $model['course_disease'] = (string)$user['course_disease'];
        $model['mobile_time'] = (string)$user['mobile_time'];
        $model['treatment'] = (string)$user['treatment'];
        $model['illness_content'] = (string)$user['illness_content'];

        $jsonData['model'] = $model;
 
        return $jsonData;
    }

}