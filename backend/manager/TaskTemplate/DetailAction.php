<?php

namespace backend\manager\TaskTemplate;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use backend\models\TaskTemplate;


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

        $model = TaskTemplate::find()->where(['id'=>$id])->limit(1)->asArray()->one();
        if(empty($model)){
            throw new ApiException('固定任务模板未找到',1);
        }
 
        $model['department_ids'] = $model['department_ids'] ? explode(',',$model['department_ids']) : array();
        $model['user_ids'] = $model['user_ids'] ? explode(',',$model['user_ids']) : array();
        $model['data_ids'] = $model['data_ids'] ? explode(',',$model['data_ids']) : array();
        $model['text_ids'] = $model['text_ids'] ? explode(',',$model['text_ids']) : array();

 

        $jsonData['model'] = $model;
 
        return $jsonData;
    }

}