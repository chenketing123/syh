<?php

namespace backend\manager\common;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\DownloadSearch;
use yii\data\Pagination;
use backend\models\LiveActivity;
use backend\models\OtherTask;
 

/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class OtherTaskListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $keywords = $this->RequestData('keywords','');
 


        $where = ['and'];
        if($keywords){
            $where[] = ['like','title',$keywords];
        }
 

        $list = OtherTask::find()->select('id,title')->where($where)->andWhere(['delete_status'=>2])->limit(200)->orderBy('id desc')->asArray()->all();

        
        foreach ($list as $k => &$v){
            $v['id'] = (int)$v['id'];
        }
 


        $jsonData['list'] = $list;


        return $jsonData;



    }

}