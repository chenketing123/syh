<?php

namespace backend\manager\BlacklistLog;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\BlacklistLogSearch;
use yii\data\Pagination;


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

 
        $search = new BlacklistLogSearch();
        $data = $search->search($request->get());
        $count = $data->count();
        $pageNum = ceil($count/$num);
 
        if($pageNum < $page && $pageNum != 0){
            throw new ApiException('分页过大',1);
        }
        $pages = new Pagination(['totalCount' => $count,'pageSize' =>$num, 'page'=>$page-1]);
        $models = $data->offset($pages->offset)->orderBy('id desc')->limit($pages->limit)->all();

        $list = array();
        foreach ($models as $k => $v) {
            $list[$k]['id'] = $v['id'];
            $list[$k]['type'] = $v['type'];
            $list[$k]['room_id'] = $v['room_id'];
            $list[$k]['user_id'] = $v['user_id'];
            $list[$k]['employee_id'] = $v['employee_id'];
            $list[$k]['append'] = $v['append'];

            
            $list[$k]['type_string'] = \backend\models\BlacklistLog::$type[$v['type']];
            $list[$k]['room_name'] = \backend\models\LiveRoom::getName($v['room_id']);
            $list[$k]['nickname'] = \backend\models\User::getName($v['user_id']);



            $list[$k]['employee_name'] = \backend\models\Employee::getName($v['employee_id']);
            $list[$k]['append_string'] = date('Y-m-d H:i:s',$v['append']);
 
 


        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }

}