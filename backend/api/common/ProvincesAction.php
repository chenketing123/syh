<?php

namespace backend\api\common;

use backend\models\Params;
use backend\models\Provinces;
use common\base\api\ApiAction;
use Yii;

class ProvincesAction extends ApiAction
{
    protected function runAction()
    {
        $pid = $this->RequestData('parent_id',0);
        $data = Provinces::getLiveList($pid);
        $jsonData['list'] = Params::SetList($data);
        $jsonData['data'] = $data;

        return $jsonData;
    }

}