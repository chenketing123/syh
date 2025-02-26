<?php

namespace backend\manager\UserHandover;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\components\CommonFunction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use backend\models\UserHandover;


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

        $model = UserHandover::find()->where(['id'=>$id])->limit(1)->one();
        if(empty($model)){
            throw new ApiException('交接信息未找到',1);
        }

        $data = array();

        foreach ($model as $k=>$v){
            $data[$k]=$v;
        }

        $data['room_name'] = \backend\models\LiveRoom::getName($model['room_id']);
        $data['user_ids'] =  $model['user_ids'] ? explode(',',$model['user_ids']) : array();

        $data['images'] = CommonFunction::setImg($data['images']);
        $data['user_list'] = array();

        foreach ($model->getUserList() as $v){
            $data['user_list'][]=array(
                'id'=>$v['id'],
                'nickname' => $v['nickname'],
                'name' => $v['name'],
                'phone' => $v['phone'],
            );
        }

        $jsonData['model'] = $data;
 
        return $jsonData;
    }

}