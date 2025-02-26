<?php

namespace backend\manager\Department;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\ArrayArrange;
use backend\models\Department;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class ListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {
        $list = Department::find()->orderBy('sort Asc,id desc')->asArray()->all();
        foreach ($list as $k => $v) {
            $list[$k]['leader_name'] = \backend\models\Employee::getName($v['leader']);

        }
        $list = ArrayArrange::items_merge_list($list,'id',0,'parentid');

 


        $jsonData['list'] = $list;
 

        return $jsonData;
    }

}