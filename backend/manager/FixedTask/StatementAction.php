<?php

namespace backend\manager\FixedTask;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\data\Pagination;
use backend\models\FixedTask;
use backend\search\FixedTaskLogSearch;
use backend\search\FixedTaskSearch;
use backend\models\TextTask;
use backend\models\OtherTask;


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

        $month = $this->RequestData('month',date('Y-m'));
 
        $models = array();
        foreach (FixedTask::$task_type as $k=>$v){
            $models[]=array(
                'id'=>$k,
                'month' => $month,
                'title' => $v,
                'finish_number' => FixedTask::find()->where(['task_type'=>$k,'type'=>1,'month'=>$month,'finish_status'=>1])->count(),
                'not_finish_number' => FixedTask::find()->where(['task_type'=>$k,'type'=>1,'month'=>$month,'finish_status'=>2])->count(),
            );
        }
        foreach (TextTask::getList() as $k=>$v){
            $models[]=array(
                'id'=>$k,
                'month' => $month,
                'title' => $v,
                'finish_number' => FixedTask::find()->where(['task_type'=>$k,'type'=>2,'month'=>$month,'finish_status'=>1])->count(),
                'not_finish_number' => FixedTask::find()->where(['task_type'=>$k,'type'=>2,'month'=>$month,'finish_status'=>2])->count(),
            );
        }
        $models[]=array(
            'id'=>0,
            'month' => $month,
            'title' => '其他任务',
            'finish_number' => OtherTask::find()->andWhere(['month'=>$month,'delete_status'=>2])->andWhere(['in','status',array(2,3)])->count(),
            'not_finish_number' => OtherTask::find()->andWhere(['month'=>$month,'delete_status'=>2,'status'=>1])->count(),
        );






 
 

        $jsonData['list'] = $models;
 

        return $jsonData;
    }
 
 



}