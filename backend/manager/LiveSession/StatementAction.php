<?php

namespace backend\manager\LiveSession;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\LiveSessionSearch;
use yii\data\Pagination;
use backend\models\LiveSession;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class StatementAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {
        $request  = Yii::$app->request;

        $num = $this->RequestData('num',20);
        $page = $this->RequestData('page',1);

 
        $search = new LiveSessionSearch();
        $data=$search->search($request->get());
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
            $list[$k]['activity_id'] = $v['activity_id'];
            $list[$k]['name'] = $v['name'];
 
            $list[$k]['room_title'] = \backend\models\LiveRoom::getName($v['room_id']);
            $list[$k]['activity_title'] = \backend\models\LiveActivity::getName($v['activity_id']);
            $list[$k]['data_count'] = $v->getDataCount();
            $list[$k]['full_count'] = $v->getFullCount();
            $list[$k]['not_count'] = $v->getDataCount()-$v->getFullCount();

 


        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }

}