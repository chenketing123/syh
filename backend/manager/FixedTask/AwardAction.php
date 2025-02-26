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
use backend\models\Employee;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class AwardAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {
        $request  = Yii::$app->request;

        $month = $this->RequestData('month',date('Y-m'));
        $user_id = $this->RequestData('user_id',0);
        $num = $this->RequestData('num',20);
        $page = $this->RequestData('page',1);



        
        $query = Employee::find()->alias('e');

        $query->join('LEFT JOIN',FixedTask::tableName()." AS ft","ft.user_id = e.id and ft.month='".$month."'");

        if(!empty($user_id)){
            $query->andWhere(['e.id'=>$user_id]);
        }
        $query->groupBy('e.id');
        $query->select('e.id,e.name,e.mobile,ft.month,sum(ft.award) as award');
        $count = $query->count();
        $pageNum = ceil($count/$num);

        $pages = new Pagination(['totalCount' =>$query->count(), 'pageSize' =>$num, 'page'=>$page-1]);
        $list = $query->offset($pages->offset)->orderBy('ft.month desc,e.id desc')->limit($pages->limit)->asArray()->all();

        foreach ($list as $k => $v) {
            $list[$k]['month'] = $v['month'] ? $v['month'] : '';
            $list[$k]['award'] = $v['award'] ? $v['award'] : '';
 
        }


 

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }
 
 



}