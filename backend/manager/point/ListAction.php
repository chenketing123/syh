<?php

namespace backend\manager\point;

use backend\models\LiveRoom;
use backend\models\PointLog;
use backend\models\User;
use backend\search\PointLogSearch;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\data\Pagination;

/**
 * @Class ListAction
 * @package backend\manager\point
 * @User:五更的猫
 * @DateTime: 2023/12/13 9:25
 * @TODO 用户积分记录列表
 */
class ListAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $num = $this->RequestData('num',10);
        $page = $this->RequestData('page',1);
        $room_id = $this->RequestData('room_id',null);
        $type = $this->RequestData('type',null);
        $uid = $this->RequestData('uid',null);

        $search = new PointLogSearch();
        $searchData = array(
            'uid'=>$uid,
            'room_id' => $room_id,
            'type' => $type,
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

        $typearr = PointLog::$typearr;
        $typearr2 = PointLog::$type;

        foreach ($model as $k => $v) {
            $models[]=array(
                'id' => $v['id'],
                'room_id' => $v['room_id'],
                'room_text' => LiveRoom::getName($v['room_id']),
                'uid' => $v['uid'],
                'name' => User::getName($v['uid']),
                'price' => $typearr[$v->type].$v->price,
                'balance' => $v['balance'],
                'type' => $v['type'],
                'type_text' => $typearr2[$v->type],
                'msg' => $v['msg'],
                'date' => date('Y-m-d H:i:s',$v['append']),
            );
        }

        $jsonData['list'] = $models;

        return $jsonData;
    }

}