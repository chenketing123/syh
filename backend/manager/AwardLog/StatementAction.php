<?php

namespace backend\manager\AwardLog;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\AwardLogSearch;
use yii\data\Pagination;
use backend\models\AwardLog;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class StatementAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {
        $request  = Yii::$app->request;

        $search = new AwardLogSearch();
        $data=$search->search($request->get());

        $data1 = serialize($data);
        $data1 = unserialize($data1);

        $data2 = serialize($data);
        $data2 = unserialize($data2);

        $data3 = serialize($data);
        $data3 = unserialize($data3);

        $model = array(
            //待领取奖励数、
            'status1_number' => $data1->andWhere(['status'=>1])->count(),
            //待上单奖励数、
            'status2_number' => $data2->andWhere(['status'=>2])->count(),
            //已上单奖励数、
            'status3_number' => $data3->andWhere(['status'=>3])->count(),
            //待领取奖励人数、
            'status1_user_number' => $data1->groupBy('user_id')->count(),
            //待上单奖励人数、
            'status2_user_number' => $data2->groupBy('user_id')->count(),
            //已上单奖励人数
            'status3_user_number' => $data3->groupBy('user_id')->count(),
        );

        $jsonData['list'] = $model;

        return $jsonData;
    }

 

 




}