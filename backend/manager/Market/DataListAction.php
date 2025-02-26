<?php

namespace backend\manager\Market;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\MarketSearch;
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
        $num = $this->RequestData('num',20);
        $page = $this->RequestData('page',1);


 

        $room = LiveRoom::getList(1);
        $room_id = empty($room_id) || !isset($room[$room_id])?key($room):$room_id;

 
        $getData = $request->get();
        $getData['room_id'] = $room_id;
 


        $search = new MarketSearch();
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
            $list[$k]['title'] = $v['title'];
            $list[$k]['manager'] = $v['manager'];
 
            
            $list[$k]['room_user_count'] = $v->getRoomUserCount($room_id);
            $list[$k]['new_room_user_count'] = $v->getNewRoomUserCount($room_id);
            $list[$k]['room_view_count'] = $v->getRoomViewCount($room_id);
            $list[$k]['root_not_view_count'] = $v->getRoomViewCount($room_id) - $v->getRoomFullViewCount($room_id);
            $list[$k]['activity_full_2_view_count'] = $v->getRoomFull2ViewCount($room_id);
            $list[$k]['activity_full_view_count'] = $v->getRoomFullViewCount($room_id);


 

        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }

}