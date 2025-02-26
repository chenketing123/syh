<?php

namespace backend\manager\manager;

use backend\models\Manager;
use backend\models\Params;
use backend\models\Provinces;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\components\CommonFunction;
use common\exception\ApiException;
use Yii;

/**
 * @Class DetailsAction
 * @package backend\manager\pointRewardType
 * @User:五更的猫
 * @DateTime: 2023/12/13 15:15
 * @TODO 管理员详情
 */
class DetailsAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $id = $this->RequestData('id',null);

        if(empty($id)){
            throw new ApiException('请选择管理员账号',1);
        }
        $model = Manager::findOne($id);
        if(empty($model)){
            throw new ApiException('未找到此管理员账号',1);
        }

        $jsonData = array(
            'id'=>$model->id,
            'username' => (string)$model->username,
            'realname'                => (string)$model->realname,
            'head_portrait'           => (string)CommonFunction::setImg($model->head_portrait),
            'sex'                     => $model->sex,
            'sex_text'                => Params::$sex2[$model->sex],
            'email'                   => (string)$model->email,
            'birthday'                => (string)$model->birthday,
            'address'                 => (string)$model->address,
            'provinces'               => $model->provinces,
            'provinces_text'          => Provinces::getNameDefault($model->provinces),
            'city'                    => $model->city,
            'city_text'               => Provinces::getNameDefault($model->city),
            'area'                    => $model->area,
            'area_text'               => Provinces::getNameDefault($model->area),
            'mobile_phone'            => (string)$model->mobile_phone,
            'role_id'                 => $model->role_id,
            'role_text'               => $model->getRoleName(),
        );

        return $jsonData;
    }

}