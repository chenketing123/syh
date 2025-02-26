<?php

namespace backend\manager\Activity;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\ActivitySearch;
use yii\data\Pagination;
use backend\models\Activity;


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

 
        $search = new ActivitySearch();
        $data=$search->search($request->get());
        $count = $data->count();
        $pageNum = ceil($count/$num);

        if($pageNum < $page && $pageNum != 0){
            throw new ApiException('分页过大',1);
        }
        $pages = new Pagination(['totalCount' => $count,'pageSize' =>$num, 'page'=>$page-1]);
        $models = $data->offset($pages->offset)->limit($pages->limit)->orderBy('sort asc,id desc')->all();

        $list = array();
        foreach ($models as $k => $v) {
            $list[$k]['id'] = $v['id'];
            $list[$k]['name'] = $v['name'];
            $list[$k]['cover'] = Yii::$app->request->hostInfo.$v['cover'];
            $list[$k]['apply_start_time'] = $v['apply_start_time'];
            $list[$k]['apply_end_time'] = $v['apply_end_time'];
            $list[$k]['start_time'] = $v['start_time'];
            $list[$k]['end_time'] = $v['end_time'];
            $list[$k]['sort'] = $v['sort'];
            $list[$k]['address'] = $v['address'];
            $list[$k]['type'] = $v['type'];
            $list[$k]['number'] = $v['number'];
            $list[$k]['limit'] = $v->limit==0?'无上限':$v->limit;
            $list[$k]['apply_status'] = $v['apply_status'];

            $list[$k]['type_string'] = \backend\models\Activity::$type[$v->type];
            $list[$k]['apply_status_string'] = \backend\models\Activity::$apply_status[$v->apply_status];

            $list[$k]['status'] = $v->status;

        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }


 



}