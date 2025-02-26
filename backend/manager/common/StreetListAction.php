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
use backend\models\EmployeeRoom;
use backend\models\LiveRoom;
use backend\models\Department;
use backend\models\User;
use backend\models\Street;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class StreetListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $keywords = $this->RequestData('keywords','');
        $province = $this->RequestData('province',0);
        $city = $this->RequestData('city',0);
        $district = $this->RequestData('district',0);
  
        $where = ['and'];

        $where[] = ['=','province',$province];
        $where[] = ['=','city',$city];
        $where[] = ['=','district',$district];
        if($keywords){
            $where[] = ['like','name',$keywords];
        }

        $list = Street::find()->where($where)->select('id,name,province,city,district')->orderBy('id desc')->asArray()->all();

        foreach ($list as $k => &$v){
            $v['id'] = (int)$v['id'];
        }

        $jsonData['list'] = $list;

        return $jsonData;



    }

}