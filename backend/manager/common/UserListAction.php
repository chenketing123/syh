<?php

namespace backend\manager\common;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\DownloadSearch;
use yii\data\Pagination;
use backend\models\User;
 

/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class UserListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $keywords = $this->RequestData('keywords','');
  


        $where = ['and'];
        if($keywords){
            $where[] = ['or',['like','id',$keywords],['like','name',$keywords],['like','nickname',$keywords],['like','phone1',$keywords],['like','phone2',$keywords]];
        }

        $models = User::find()->select('id, name, nickname,phone1,phone2')->where($where)->limit(200)->orderBy('id desc')->asArray()->all();
 

        $list = array();
        $list[] = array(
            'id'=>"0",
            'text'=>'无'
        );
        foreach ($models as $v){
            $list[] = array(
                'id'=>(int)$v['id'],
                'text'=>$v['id'].'_'.$v['nickname'].'_'.$v['name'].'_'.$v['phone1'].'_'.$v['phone2']
            );
        }

        $jsonData['list'] = $list;


        return $jsonData;



    }

}