<?php

namespace backend\manager\LiveSession;

use backend\models\LoginForm;
use backend\models\Manager;
use backend\models\QuestionBank;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use backend\models\LiveSession;


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

        $model = LiveSession::find()->where(['id'=>$id])->limit(1)->asArray()->one();
        if(empty($model)){
            throw new ApiException('直播场次未找到',1);
        }
 
        $model['cover'] = Yii::$app->request->hostInfo.$model['cover'];
        $model['room_title'] = \backend\models\LiveRoom::getName($model['room_id']);
        $model['activity_title'] = \backend\models\LiveActivity::getName($model['activity_id']);
        $model['append_string'] = date('Y-m-d H:i:s',$model['append']);
        $model['province_name'] = \backend\models\Provinces::getName2($model['province']);
        $model['city_name'] = \backend\models\Provinces::getName2($model['city']);
        $model['district_name'] = \backend\models\Provinces::getName2($model['district']);

        $street = \backend\models\Street::findOne($model['street']);
        $model['street_name'] = $street ? $street['name'] : '';

        $model['entity1'] = $model['entity1'] ? explode(',',$model['entity1']) : array();
        $model['entity2'] = $model['entity2'] ? explode(',',$model['entity2']) : array();


        $model['question_ids'] = $model['question_ids'] ? explode(',',$model['question_ids']) : array();

        $model['question_arr'] = array();

        foreach ($model['question_ids'] as $v){
            $model['question_arr'][]=array(
                'id'=>$v,
                'title'=>QuestionBank::getName($v),
            );
        }

        $jsonData['model'] = $model;
 
        return $jsonData;
    }

}