<?php

namespace backend\manager\LiveRoom;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use backend\models\LiveRoom;


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

        $model = LiveRoom::find()->where(['id'=>$id])->limit(1)->asArray()->one();
        if(empty($model)){
            throw new ApiException('直播间未找到',1);
        }
 


        $model['cover'] = $model['cover'] ? Yii::$app->request->hostInfo.$model['cover'] : '';
        $model['cover2'] = $model['cover2'] ? Yii::$app->request->hostInfo.$model['cover2'] : '';
        $model['cover3'] = $model['cover3'] ? Yii::$app->request->hostInfo.$model['cover3'] : '';
        $model['cover4'] = $model['cover4'] ? Yii::$app->request->hostInfo.$model['cover4'] : '';
        $model['app_cover'] = $model['app_cover'] ? Yii::$app->request->hostInfo.$model['app_cover'] : '';
        $model['share_img'] = $model['share_img'] ? Yii::$app->request->hostInfo.$model['share_img'] : '';
        $model['goods_title'] = \backend\models\Goods::getName($model['goods_id']);


        $jsonData['model'] = $model;
 
        return $jsonData;
    }

}