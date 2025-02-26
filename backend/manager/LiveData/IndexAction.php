<?php

namespace backend\manager\LiveData;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\LiveDataSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\LiveRoom;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class IndexAction extends ManagerApiAction
{
    protected function runAction()
    {
        $request  = Yii::$app->request;

        $num = $this->RequestData('num',20);
        $page = $this->RequestData('page',1);

 
        $search = new LiveDataSearch();
        $data=$search->search($request->get());
        $data2=$search->search($request->get());
        $count_full = $data2->andWhere(['is_full'=>1])->count();
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
            $list[$k]['session_id'] = $v['session_id'];
            $list[$k]['user_id'] = $v['user_id'];
            $list[$k]['nickname'] = $v['nickname'];
            $list[$k]['sex'] = $v['sex'];
            $list[$k]['ip'] = $v['ip'];
            $list[$k]['one_date'] = $v['one_date'];
            $list[$k]['new_date'] = $v['new_date'];
            $list[$k]['live_times'] = $v['live_times'];
            $list[$k]['play_times'] = $v['play_times'];
            $list[$k]['openid'] = $v['openid'];
 
            $list[$k]['room_title'] = \backend\models\LiveRoom::getName($v['room_id']);
            $list[$k]['activity_name'] = \backend\models\LiveActivity::getName($v['activity_id']);
            $list[$k]['session_name'] = \backend\models\LiveSession::getName($v['session_id']);

        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;
        $jsonData['count_full'] = $count_full;





        return $jsonData;
 


    }

}