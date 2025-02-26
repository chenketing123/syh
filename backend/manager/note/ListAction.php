<?php

namespace backend\manager\note;

use backend\models\LiveActivity;
use backend\models\LiveRoom;
use backend\models\Note;
use backend\models\PointRewardType;
use backend\models\User;
use backend\search\NoteSearch;
use common\base\api\ManagerApiAction;
use common\components\CommonFunction;
use common\exception\ApiException;
use Yii;
use yii\data\Pagination;

/**
 * @Class ListAction
 * @package backend\manager\pointReward
 * @User:五更的猫
 * @DateTime: 2023/12/13 15:56
 * @TODO 客户笔记记录列表
 */
class ListAction extends ManagerApiAction
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
        $status = $this->RequestData('status',null);
        $is_open = $this->RequestData('is_open',null);

        $search = new NoteSearch();
        $searchData = array(
            'room_id'=>$room_id,
            'activity_id' => $activity_id,
            'session_id' => $session_id,
            'user_id' => $user_id,
        );
        if(!empty($status)){
            $searchData['status'] = $status;
        }
        if(!empty($is_open)){
            $searchData['is_open'] = $is_open;
        }
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
        $typeArr = array();
        $roomArr = array();
        $userArr = array();
        $ActivityArr = array();


        foreach ($model as $k => $v) {
            if(!isset($roomArr[$v['room_id']])){
                $roomArr[$v['room_id']] = LiveRoom::getName($v['room_id']);
            }
            if(!isset($userArr[$v['user_id']])){
                $userArr[$v['user_id']] = User::getName($v['user_id']);
            }
            if(!isset($ActivityArr[$v['activity_id']])){
                $ActivityArr[$v['activity_id']] = LiveActivity::getName($v['activity_id']);
            }
            $models[]=array(
                'id' => $v['id'],
                'user_id' => $v['user_id'],
                'user_text' => $userArr[$v['user_id']],
                'room_id' => $v['room_id'],
                'room_text' => $roomArr[$v['room_id']],
                'activity_id' => $v['activity_id'],
                'activity_text' => $ActivityArr[$v['activity_id']],
                'title' => $v['title'],
                'images' => CommonFunction::setImg($v['images']),
                'content' => $v['content'],
                'video' => CommonFunction::setImg($v['video']),
                'name' => $v['name'],
                'phone' => $v['phone'],
                'price' => $v['price'],
                'status' => Note::$status[$v['status']],
                'date' => date('Y-m-d H:i:s',$v['append']),
                'is_open'=>$v['is_open'],
            );
        }

        $jsonData['list'] = $models;

        return $jsonData;
    }

}