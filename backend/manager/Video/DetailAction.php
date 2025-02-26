<?php

namespace backend\manager\Video;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use backend\models\Video;
use backend\models\Street;


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

        $model = Video::find()->where(['id'=>$id])->limit(1)->asArray()->one();
        if(empty($model)){
            throw new ApiException('视频未找到',1);
        }
 

        $model['room_name'] = \backend\models\LiveRoom::getName($model['room_id']);
        $model['cover'] = Yii::$app->request->hostInfo.$model['cover'];
        $model['province_name'] = \backend\models\Provinces::getName($model['province']);
        $model['city_name'] = \backend\models\Provinces::getName($model['city']);
        $model['district_name'] = \backend\models\Provinces::getName($model['district']);

        $street = Street::findOne($model['street']);
        $model['street_name'] = $street ? $street['name'] : '';
        $model['entity'] = $model['entity'] ? explode(',',$model['entity']) : array();

 

        // $model['department_ids'] = $model['department_ids'] ? explode(',',$model['department_ids']) : array();
        // $model['data_ids'] = $model['data_ids'] ? explode(',',$model['data_ids']) : array();
        // $model['text_ids'] = $model['text_ids'] ? explode(',',$model['text_ids']) : array();

 

        $jsonData['model'] = $model;
 
        return $jsonData;
    }

}