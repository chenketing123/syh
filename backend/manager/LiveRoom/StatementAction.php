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
class StatementAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {
        $request  = Yii::$app->request;

        $num = $this->RequestData('num',20);
        $page = $this->RequestData('page',1);

 
        $data = LiveRoom::find()->where(['status'=>1]);
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
  
            $list[$k]['data_user_count'] = $v->getDataUserCount();
            $list[$k]['full_user_count'] = $v->getFullUserCount();
            $list[$k]['room_full_user_count'] = $v->getRoomFullUserCount();
            $list[$k]['not_full_user_count'] = $v->getFullUserCount() - $v->getRoomFullUserCount();
            $list[$k]['not_data_user_count'] = $v->getDataUserCount() - $v->getRoomFullUserCount();

        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }


 



}