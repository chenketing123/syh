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
class IndexAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {
        $request  = Yii::$app->request;

        $num = $this->RequestData('num',20);
        $page = $this->RequestData('page',1);

 
        $search = new AwardLogSearch();
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
            $list[$k]['user_id'] = $v['user_id'];
            $list[$k]['phone'] = $v['phone'] ? $v['phone'] : '';
            $list[$k]['room_id'] = $v['room_id'];
            $list[$k]['activity_id'] = $v['activity_id'];
            $list[$k]['list_type'] = $v['list_type'];
            $list[$k]['send_type'] = $v['send_type'];
            $list[$k]['type'] = $v['type'];
            $list[$k]['award_type'] = $v['award_type'];
            $list[$k]['is_calculation'] = $v['is_calculation'];
            $list[$k]['award_title'] = $v['award_title'] ? $v['award_title'] : '';
            $list[$k]['end_date'] = $v['end_date'];
            $list[$k]['verify_date'] = $v['verify_date'] ? $v['verify_date'] : '';
            $list[$k]['verify_user_id'] = $v['verify_user_id'];
            $list[$k]['status'] = $v['status'];
            $list[$k]['append'] = $v['append'];

            $list[$k]['user_name'] = \backend\models\User::getName($v->user_id);
            $list[$k]['room_name'] = \backend\models\LiveRoom::getName($v->room_id);
            $list[$k]['activity_name'] = $v->activity_id ? \backend\models\LiveActivity::getName($v->activity_id) : '无';
            $list[$k]['list_type_string'] = \backend\models\AwardLog::$list_type[$v->list_type];
            $list[$k]['send_type_string'] = \backend\models\AwardLog::$send_type[$v->send_type];
            $list[$k]['type_string'] = \backend\models\AwardLog::$type[$v->type];
            $list[$k]['award_type_string'] = \backend\models\AwardLog::$award_type[$v->award_type];
            $list[$k]['is_calculation_string'] = \backend\models\Params::$is[$v->is_calculation];
            $list[$k]['verify_user_name'] = \backend\models\Employee::getName($v->verify_user_id);
            $list[$k]['get_status_string'] = $v->getStatus();
            $list[$k]['status_string'] = \backend\models\AwardLog::$status[$v->status];
            $list[$k]['append_string'] = date('Y-m-d H:i:s',$v->append);

        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }

 

 




}