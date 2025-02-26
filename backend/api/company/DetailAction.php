<?php

namespace backend\api\company;
use backend\models\Company;
use common\base\api\CommonApiAction;
use common\components\Helper;
use common\exception\ApiException;
use Yii;


class DetailAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {
        $id = $this->RequestData('id',1);
        $model = Company::findOne($id);
        if (!$model) {
            throw new ApiException('id不正确', 1);
        }


        $jsonData['detail']=Helper::model_message($model);
        $jsonData['detail']['industry']=explode(',',$jsonData['detail']['industry']);
        $jsonData['errmsg'] = '';
        return $jsonData;
    }

}