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
use backend\models\Market;
use backend\models\User;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class MarketListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $keywords = $this->RequestData('keywords','');
  
        $where = ['and'];
        if($keywords){
            $where[] = ['like','title',$keywords];
        }

        $list = Market::find()->where($where)->select('id,title')->asArray()->all();

        foreach ($list as $k=>$v){
            $list[$k]['id'] = (int)$v['id'];
        }

        $jsonData['list'] = $list;


        return $jsonData;



    }

}