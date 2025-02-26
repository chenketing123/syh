<?php

namespace backend\manager\UserHandover;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserHandoverSearch;
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

 
        $search = new UserHandoverSearch();
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
            $list[$k]['room_id'] = $v['room_id'];
            $list[$k]['out_user_name'] = $v['out_user_name'];
            $list[$k]['in_user_name'] = $v['in_user_name'];
            $list[$k]['handover_user_name'] = $v['handover_user_name'];
            $list[$k]['date'] = $v['date'];
            $list[$k]['remark'] = $v['remark'];
            $list[$k]['status'] = $v['status'];
            $list[$k]['append'] = $v['append'];

            
            $list[$k]['status_string'] = \backend\models\UserHandover::$status[$v['status']];
            $list[$k]['room_name'] = \backend\models\LiveRoom::getName($v['room_id']);
            $list[$k]['append_string'] = date('Y-m-d H:i:s',$v['append']);
 
 


        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }

}