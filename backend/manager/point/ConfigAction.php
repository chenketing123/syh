<?php

namespace backend\manager\point;

use backend\models\ApplyWithdraw;
use backend\models\Codes;
use backend\models\LiveRoom;
use backend\models\Params;
use backend\models\PointLog;
use backend\models\User;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\base\Exception;
use yii\data\Pagination;

/**
 * Class WithdrawAction
 * @package backend\api\user
 * User:五更的猫
 * DateTime:2022/11/11 13:41
 * TODO 用户申请提现
 */
class ConfigAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {
        $type = PointLog::$type;

        $jsonData['type']=Params::SetList($type);

        return $jsonData;
    }

}