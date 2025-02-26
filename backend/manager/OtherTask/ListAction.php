<?php

namespace backend\manager\OtherTask;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\data\Pagination;
use backend\models\OtherTask;
use backend\search\OtherTaskLogSearch;
use backend\search\OtherTaskSearch;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class ListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {
        $request  = Yii::$app->request;

        $num = $this->RequestData('num',20);
        $page = $this->RequestData('page',1);

 
        $search = new OtherTaskSearch();
        $search->delete_status = 2;
        $data=$search->search($request->get());
        $count = $data->count();
        $pageNum = ceil($count/$num);

        if($pageNum < $page && $pageNum != 0){
            throw new ApiException('分页过大',1);
        }
        $pages = new Pagination(['totalCount' => $count,'pageSize' =>$num, 'page'=>$page-1]);
        $models = $data->offset($pages->offset)->limit($pages->limit)->orderBy('id desc')->all();

        $list = array();
        foreach ($models as $k => $v) {
            $list[$k]['id'] = $v['id'];
            $list[$k]['employee_id'] = $v['employee_id'];
            $list[$k]['task_type'] = $v['task_type'];
            $list[$k]['task_id'] = $v['task_id'];
            $list[$k]['title'] = $v['title'];
            $list[$k]['user_name'] = $v['user_name'];
            $list[$k]['month'] = $v['month'];
            $list[$k]['start_time'] = $v['start_time'];
            $list[$k]['end_time'] = $v['end_time'];
            $list[$k]['status'] = $v['status'];
            $list[$k]['append'] = $v['append'];
 

            $list[$k]['employee_name'] = \backend\models\Employee::getName($v->employee_id);
            $list[$k]['task_type_string'] = \backend\models\OtherTask::$task_type[$v->task_type];
            $list[$k]['status_string'] = \backend\models\OtherTask::$status[$v->status];
            $list[$k]['task_title'] = \backend\models\OtherTask::getName($v->task_id);
            $list[$k]['append_string'] = date('Y-m-d H:i:s',$v->append);

        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }
 
 
 



}