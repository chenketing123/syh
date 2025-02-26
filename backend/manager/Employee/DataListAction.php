<?php

namespace backend\manager\Employee;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\EmployeeSearch;
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
class DataListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {


        $request  = Yii::$app->request;

        $room_id = $this->RequestData('room_id',10);
        $market = $this->RequestData('market',10);
        $num = $this->RequestData('num',20);
        $page = $this->RequestData('page',1);

        $room = LiveRoom::getList();
        $room_id = empty($room_id) || !isset($room[$room_id]) ? key($room) : $room_id;
        $activity_id = LiveActivity::find()->where(['room_id'=>$room_id])->orderBy('sort asc,id desc')->one();
        $activity_id = empty($activity_id)?0:$activity_id->id;

        $getData = $request->get();
        $getData['room_id'] = $room_id;
        $getData['activity_id'] = $activity_id;



        $search = new EmployeeSearch();
        $data=$search->search($getData);

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
            $list[$k]['name'] = $v['name'];
            $list[$k]['market'] = $v['market'];
 
            
            $list[$k]['market_string'] = \backend\models\Market::getName($v->market);
            $list[$k]['user_count'] = $v->getUserCount($room_id);
            $list[$k]['new_user_count'] = $v->getNewUserCount($room_id);
            $list[$k]['activity_view_count'] = $v->getActivityViewCount($activity_id);
            $list[$k]['activity_not_view_count'] = $v->getActivityViewCount($activity_id) - $v->getActivityFullCount($activity_id);
            $list[$k]['activity_full_2_count'] = $v->getActivityFull2Count($activity_id);
            $list[$k]['activity_full_count'] = $v->getActivityFullCount($activity_id);


 

        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }

}