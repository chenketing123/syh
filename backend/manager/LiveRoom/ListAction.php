<?php

namespace backend\manager\LiveRoom;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use backend\models\LiveRoom;


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

        $num = $this->RequestData('num',20);
        $page = $this->RequestData('page',1);

 
        $data = LiveRoom::find();
        $count = $data->count();
        $pageNum = ceil($count/$num);

        if($pageNum < $page && $pageNum != 0){
            throw new ApiException('分页过大',1);
        }
        $pages = new Pagination(['totalCount' => $count,'pageSize' =>$num, 'page'=>$page-1]);
        $models = $data->offset($pages->offset)->limit($pages->limit)->orderBy('sort asc,id desc')->all();

        $list = array();
        foreach ($models as $k => $v) {
            $list[$k]['id'] = $v['id'];
            $list[$k]['title'] = $v['title'];
            $list[$k]['cover'] = $v['cover'] ? Yii::$app->request->hostInfo.$v['cover'] : '';
            $list[$k]['live_time'] = $v['live_time'];
            $list[$k]['full_count'] = $v['full_count'];
            $list[$k]['full2_count'] = $v['full2_count'];
            $list[$k]['buy_give_number'] = $v['buy_give_number'];
            $list[$k]['sort'] = $v['sort'];
            $list[$k]['status'] = $v['status'];
 

        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }

}