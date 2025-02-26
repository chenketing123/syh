<?php

namespace backend\manager\UserRoom;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserRoomSearch;
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

 
        $search = new UserRoomSearch();
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
            $list[$k]['user_id'] = $v['user_id'];
            $list[$k]['room_id'] = $v['room_id'];
            $list[$k]['employee_id'] = $v['employee_id'];
            $list[$k]['is_show_live'] = $v['is_show_live'];
            $list[$k]['append'] = $v['append'];
            $list[$k]['point'] = $v['point'];
            $list[$k]['zpoint'] = $v['zpoint'];
            
            $list[$k]['nickname'] = !empty($v->user)?$v->user->nickname:'未知';
            $list[$k]['name'] = !empty($v->user)?$v->user->name:'未知';
            $list[$k]['room_name'] = \backend\models\LiveRoom::getName($v['room_id']);
            $list[$k]['employee_name'] = \backend\models\Employee::getName($v['employee_id']);
            $list[$k]['is_show_live_string'] = \backend\models\UserRoom::$is_show_live[$v['is_show_live']];
            $list[$k]['append_string'] = Yii::$app->formatter->asDatetime($v['append']);

        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }

}