<?php

namespace backend\manager\UserRoom;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserRoomSearch;
use yii\data\Pagination;


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

        $num = $this->RequestData('num',20);
        $page = $this->RequestData('page',1);

 
        $search = new UserRoomSearch();
        $data = $search->search($request->get());
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
            $list[$k]['user_id'] = $v['user_id'];
            $list[$k]['room_id'] = $v['room_id'];
            $list[$k]['employee_id'] = $v['employee_id'];
            $list[$k]['append'] = $v['append'];

            
            $list[$k]['openid'] = !empty($v->user) && $v->user->openid?$v->user->openid:'未知';
            $list[$k]['nickname'] = !empty($v->user)?$v->user->nickname:'未知';
            $list[$k]['name'] = !empty($v->user)?$v->user->name:'未知';
            $list[$k]['phone1'] = !empty($v->user)?$v->user->phone1:'未知';
            $list[$k]['append_string'] = Yii::$app->formatter->asDatetime($v['append']);
            $list[$k]['room_name'] = \backend\models\LiveRoom::getName($v['room_id']);




            $list[$k]['employee_name'] = !empty($v->employee)?$v->employee->name:'未知';
            $list[$k]['market'] = !empty($v->employee)?\backend\models\Market::getName($v->employee->market):'未知';
 


        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }

}