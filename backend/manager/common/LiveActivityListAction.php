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
 

/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class LiveActivityListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $keywords = $this->RequestData('keywords','');
        $room_id = $this->RequestData('room_id',0);
        $status = $this->RequestData('status',null);
 


        $where = ['and'];
        if($keywords){
            $where[] = ['like','name',$keywords];
        }
        if($room_id){
            $where[] = ['=','room_id',$room_id];
        }

        $list = LiveActivity::find()->select('id,name')->where($where)->andFilterWhere(['status'=>$status])->orderBy('sort asc,id desc')->asArray()->all();
 
        foreach ($list as $k => &$v){
            $v['id'] = (int)$v['id'];
        }
 


        $jsonData['list'] = $list;


        return $jsonData;



    }

}