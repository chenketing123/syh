<?php

namespace backend\manager\sendPoint;

use backend\models\LiveRoom;
use backend\search\SendPointSearch;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\data\Pagination;

/**
 * @Class ListAction
 * @package backend\manager\sendPoint
 * @User:五更的猫
 * @DateTime: 2023/12/13 10:30
 * @TODO 观看积分发放设置列表
 */
class ListAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $num = $this->RequestData('num',10);
        $page = $this->RequestData('page',1);
        $room_id = $this->RequestData('room_id',null);

        $search = new SendPointSearch();
        $searchData = array(
            'room_id' => $room_id,
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
        $model = $data->offset($pages->offset)->limit($pages->limit)->orderBy('time asc,id desc')->all();

        $models = array();

        foreach ($model as $k => $v) {
            $models[]=array(
                'id' => $v['id'],
                'room_id' => $v['room_id'],
                'room_text' => LiveRoom::getName($v['room_id']),
                'time' => $v['time'].'秒',
                'point' => $v['point'].'积分',
            );
        }

        $jsonData['list'] = $models;

        return $jsonData;
    }

}