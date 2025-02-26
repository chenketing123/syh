<?php

namespace backend\manager\employeeRoom;

use backend\models\LiveRoom;
use backend\search\EmployeeRoomSearch;
use backend\search\ManagerSearch;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\data\Pagination;

/**
 * @Class ListAction
 * @package backend\manager\manager
 * @User:五更的猫
 * @DateTime: 2023/12/22 9:27
 * @TODO 管理员列表
 */
class ListAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $num = $this->RequestData('num',10);
        $page = $this->RequestData('page',1);
        $room_id = $this->RequestData('room_id',null);
        $employee_id = $this->RequestData('employee_id',null);

        $search = new EmployeeRoomSearch();
        $searchData = array(
            'room_id'=>$room_id,
            'employee_id'=>$employee_id,
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

        foreach ($model as $k => $v) {
            $models[]=array(
                'id' => $v['id'],
                'name' => $v->employee->name,
                'mobile' => $v->employee->mobile,
                'room_id' => LiveRoom::getName($v['room_id']),
            );
        }

        $jsonData['list'] = $models;

        return $jsonData;
    }

}