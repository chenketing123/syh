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
use backend\models\Provinces;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class ProvinceListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $keywords = $this->RequestData('keywords','');
        $parentid = $this->RequestData('parentid',0);
  
        $where = ['and'];

        $where[] = ['=','parentid',$parentid];
        if($keywords){
            $where[] = ['like','areaname',$keywords];
        }

        $list = Provinces::find()->where($where)->select('id,areaname')->orderBy('sort asc,id desc')->limit(200)->asArray()->all();

        foreach ($list as $k => &$v){
            $v['id'] = (int)$v['id'];
        }
        
        $jsonData['list'] = $list;

        return $jsonData;



    }

}