<?php

namespace backend\manager\ActivityApply;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use backend\models\ActivityApply;
use common\components\CommonFunction;


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

        $model = ActivityApply::find()->where(['id'=>$id])->limit(1)->asArray()->one();
        $one = ActivityApply::find()->where(['id'=>$id])->limit(1)->one();
        if(empty($model)){
            throw new ApiException('报名记录未找到',1);
        }
 
        $model['type'] = $model['type'] ? explode(',',$model['type']) : array();

 
        $model['user_name'] = \backend\models\User::getName($model['user_id']);
        $model['employee_name'] = \backend\models\Employee::getName($model['employee_id']);
        $model['activity_type_string'] = \backend\models\Activity::$type[$model['activity_type']];
        $model['terminal_name'] = \backend\models\JxcTerminal::getName($model['terminal_id']);
        $model['sex_string'] = \backend\models\Params::$sex[$model['sex']];
        $model['province_string'] = \backend\models\Provinces::getName($model['province']);
        $model['city_string'] = \backend\models\Provinces::getName($model['city']);
        $model['district_string'] = \backend\models\Provinces::getName($model['district']);
        $model['append_string'] = date('Y-m-d H:i:s',$model['append']);
        $model['tohoro_type_string'] = empty($model['tohoro_type'])?'':\backend\models\ActivityApply::$tohoro_type[$model['tohoro_type']];
        $model['get_types'] = $one->getTypes();
        $model['calculate_string'] = $model['calculate']==0?$model['wuxiao']:\backend\models\ActivityApply::$calculate[$model['calculate']];
        $model['images'] = $model['images'] ? unserialize($model['images']) : array();
        foreach($model['images'] as $k => $v){
            $model['images'][$k] = CommonFunction::setImg($v);
        }
        $model['h'] = (string)$model['h'];
        $model['wuxiao'] = (string)$model['wuxiao'];


        $jsonData['model'] = $model;
 
        return $jsonData;
    }

}