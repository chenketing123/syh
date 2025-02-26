<?php

namespace backend\manager\point;

use backend\models\AwardLog;
use backend\models\Employee;
use backend\models\LiveRoom;
use backend\models\User;
use backend\search\PointOrderSearch;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\data\Pagination;

/**
 * @Class OrderAction
 * @package backend\manager\point
 * @User:五更的猫
 * @DateTime: 2023/12/13 13:52
 * @TODO 积分兑换订单列表
 */
class OrderAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $num = $this->RequestData('num',10);
        $page = $this->RequestData('page',1);
        $room_id = $this->RequestData('room_id',null);
        $status = $this->RequestData('status',null);
        $user_id = $this->RequestData('user_id',null);
        $goods_id = $this->RequestData('goods_id',null);
        $keywords = $this->RequestData('keywords',null);

        $search = new PointOrderSearch();
        $searchData = array(
            'user_id'=>$user_id,
            'room_id' => $room_id,
            'goods_id' => $goods_id,
            'keywords' => $keywords,
        );
        if(!empty($status)){
            $searchData['status'] = $status;
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
        $model = $data->offset($pages->offset)->limit($pages->limit)->orderBy('o.id desc')->select('o.*,a.end_date,a.verify_date,a.verify_user_id,a.status')->asArray()->all();

        $models = array();

        $statusArr = AwardLog::$status;

        $roomArr = array();
        $userArr = array();
        $EmployeeArr = array();

        foreach ($model as $k => $v) {
            if(!isset($roomArr[$v['room_id']])){
                $roomArr[$v['room_id']] = LiveRoom::getName($v['room_id']);
            }
            if(!isset($userArr[$v['user_id']])){
                $userArr[$v['user_id']] = User::getName($v['user_id']);
            }
            if(!isset($EmployeeArr[$v['verify_user_id']])){
                $EmployeeArr[$v['verify_user_id']] = Employee::getName($v['verify_user_id']);
            }
            $models[]=array(
                'id' => $v['id'],
                'order_no' => $v['order_no'],
                'room_id' => $v['room_id'],
                'room_text' => $roomArr[$v['room_id']],
                'user_id' => $v['user_id'],
                'user_text' => $userArr[$v['user_id']],
                'title' => $v['title'],
                'price' => $v['price'],
                'point' => $v['point'],
                'end_date' => $v['end_date'],
                'verify_date' => $v['verify_date'],
                'verify_user_id' => $v['verify_user_id'],
                'verify_user' => $EmployeeArr[$v['verify_user_id']],
                'status' => $v['status'],
                'status_text' => $statusArr[$v['status']],
                'date' => date('Y-m-d H:i:s',$v['append']),
            );
        }

        $jsonData['list'] = $models;

        return $jsonData;
    }

}