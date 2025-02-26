<?php

namespace backend\manager\LiveData;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\LiveUserSearch;
use yii\data\Pagination;
use backend\models\LiveRoom;
use backend\models\LiveActivity;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class UserListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        $request = Yii::$app->request;

        $room = LiveRoom::getList();
        $room_id = $this->RequestData('room_id',key($room));
        $num = $this->RequestData('num',20);
        $page = $this->RequestData('page',1);
        $activityList = LiveActivity::getList($room_id);
        $activity_id = $this->RequestData('activity_id',key($activityList));
 



        $search = new LiveUserSearch();
        $getData = $request->get();
        $getData['room_id'] = $room_id;
        $getData['activity_id'] = $activity_id;
        $search->room_id = $room_id;
        $search->activity_id = $activity_id;

        $data=$search->search($getData);
        $count = $data->count();
        $pageNum = ceil($count/$num);
 

        if($pageNum < $page && $pageNum != 0){
            throw new ApiException('分页过大',1);
        }
        $pages = new Pagination(['totalCount' =>$count,'pageSize' =>$num, 'page' =>$page-1]);
        $models = $data->offset($pages->offset)->orderBy('u.id desc')->limit($pages->limit)->asArray()->all();

        $list = array();
        foreach ($models as $k => $v) {
            $list[$k]['id'] = $v['id'];
            $list[$k]['openid'] = $v['openid'];
            $list[$k]['nickname'] = $v['nickname'];
            $list[$k]['employee_id'] = $v['employee_id'];
            $list[$k]['view_count'] = $v['view_count'];
            $list[$k]['full_view_count'] = $v['full_view_count'];
 
 
            $list[$k]['employee_name'] = \backend\models\Employee::getName($v['employee_id']);
            $list[$k]['employee_market'] = \backend\models\Employee::getMarket($v['employee_id']);
 
        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;





    }

}