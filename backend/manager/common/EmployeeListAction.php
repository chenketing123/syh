<?php

namespace backend\manager\common;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\DownloadSearch;
use yii\data\Pagination;
use backend\models\Employee;
 

/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class EmployeeListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $keywords = $this->RequestData('keywords','');
  


        $where = ['and'];
        if($keywords){
            $where[] = ['or',['like','name',$keywords],['like','mobile',$keywords]];
        }

        $list = Employee::find()->select('id, name, mobile')->where($where)->orderBy('is_leader asc,id desc')->asArray()->all();

        foreach ($list as &$v){
            $v['id'] = (int)$v['id'];
            $v['title'] = $v['name'].'_'.$v['mobile'];
        }

        $jsonData['list'] = $list;


        return $jsonData;



    }

}