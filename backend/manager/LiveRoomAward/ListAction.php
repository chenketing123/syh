<?php

namespace backend\manager\LiveRoomAward;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use backend\models\LiveRoomAward;
use backend\search\LiveRoomAwardSearch;


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

        $room_id = $this->RequestData('room_id','');
        $status = $this->RequestData('status','');
        $is_calculation = $this->RequestData('is_calculation','');
        $num = $this->RequestData('num',20);
        $page = $this->RequestData('page',1);

 
        $search = new LiveRoomAwardSearch();
        $search->room_id = $room_id;
        $data = $search->search($request->get());
        $count = $data->count();
        $pageNum = ceil($count/$num);

        if($pageNum < $page && $pageNum != 0){
            throw new ApiException('分页过大',1);
        }
        $pages = new Pagination(['totalCount' => $count,'pageSize' =>$num, 'page'=>$page-1]);
        $models = $data->offset($pages->offset)->limit($pages->limit)->orderBy('id desc')->all();

        $list = array();
        foreach ($models as $k => $v) {
            $list[$k]['id'] = $v['id'];
            $list[$k]['room_id'] = $v['room_id'];
            $list[$k]['goods_id'] = $v['goods_id'];
            $list[$k]['is_calculation'] = $v['is_calculation'];
            $list[$k]['status'] = $v['status'];
            $list[$k]['append'] = $v['append'];
            $list[$k]['updated'] = $v['updated'];
 

            $list[$k]['goods_title'] = \backend\models\JxcGoods::getName($v['goods_id']);
            $list[$k]['is_calculation_string'] = \backend\models\Params::$is[$v['is_calculation']];

        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }

}