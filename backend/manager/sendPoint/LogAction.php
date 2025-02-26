<?php

namespace backend\manager\sendPoint;

use backend\models\User;
use backend\models\LiveActivity;
use backend\models\LiveRoom;
use backend\models\LiveSession;
use backend\search\SendPointLogSearch;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\data\Pagination;

/**
 * @Class ListAction
 * @package backend\manager\sendPoint
 * @User:五更的猫
 * @DateTime: 2023/12/13 10:30
 * @TODO 观看积分发放列表
 */
class LogAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $num = $this->RequestData('num',10);
        $page = $this->RequestData('page',1);
        $room_id = $this->RequestData('room_id',null);
        $activity_id = $this->RequestData('activity_id',null);
        $session_id = $this->RequestData('session_id',null);
        $user_id = $this->RequestData('user_id',null);
        $point_id = $this->RequestData('point_id',null);

        $search = new SendPointLogSearch();
        $searchData = array(
            'room_id' => $room_id,
            'activity_id' => $activity_id,
            'session_id' => $session_id,
            'user_id' => $user_id,
            'point_id' => $point_id,
        );

        $data=$search->search($searchData);

        $count = $data->count();

        $pageNum = ceil($count/$num);

        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;
        if($pageNum<$page && $pageNum != 0){
            throw new ApiException('分页过大',1);
        }

        $pages = new Pagination(['totalCount' => $count,'pageSize' =>$num, 'page'=>$page-1]);
        $model = $data->offset($pages->offset)->limit($pages->limit)->orderBy('id desc')->all();

        $models = array();

        $roomArr = array();
        $userArr = array();
        $activityArr = array();
        $sessionArr = array();

        foreach ($model as $k => $v) {
            if(!isset($roomArr[$v['room_id']])){
                $roomArr[$v['room_id']] = LiveRoom::getName($v['room_id']);
            }
            if(!isset($userArr[$v['user_id']])){
                $userArr[$v['user_id']] = User::getName($v['user_id']);
            }
            if(!isset($activityArr[$v['activity_id']])){
                $activityArr[$v['activity_id']] = LiveActivity::getName($v['activity_id']);
            }
            if(!isset($sessionArr[$v['session_id']])){
                $sessionArr[$v['session_id']] = LiveSession::getName($v['session_id']);
            }
            $models[]=array(
                'id' => $v['id'],
                'room_id' => $v['room_id'],
                'room_text' => $roomArr[$v['room_id']],
                'user_id' => $v['user_id'],
                'user_text' => $userArr[$v['user_id']],
                'activity_id' => $v['activity_id'],
                'activity_text' => $activityArr[$v['activity_id']],
                'session_id' => $v['session_id'],
                'session_text' => $sessionArr[$v['session_id']],
                'time' => $v['time'],
                'point' => $v['point'],
                'date' => date('Y-m-d H:i:s',$v['append']),
            );
        }

        $jsonData['list'] = $models;

        return $jsonData;
    }

}