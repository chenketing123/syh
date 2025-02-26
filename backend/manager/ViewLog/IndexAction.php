<?php

namespace backend\manager\ViewLog;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\ViewLogSearch;
use yii\data\Pagination;
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
    public $isLogin = true;

    protected function runAction()
    {
        $request  = Yii::$app->request;

        $num = $this->RequestData('num',20);
        $page = $this->RequestData('page',1);

 
        $search = new ViewLogSearch();
        $data=$search->search($request->get());
        
        $count = $data->count();
        $pageNum = ceil($count/$num);

        if($pageNum < $page && $pageNum != 0){
            throw new ApiException('分页过大',1);
        }
        $pages = new Pagination(['totalCount' => $count,'pageSize' =>$num, 'page'=>$page-1]);
        $models = $data->offset($pages->offset)->limit($pages->limit)->orderBy('new_date desc,id desc')->all();

        $list = array();
        foreach ($models as $k => $v) {
            $list[$k]['id'] = $v['id'];
            $list[$k]['room_title'] = $v['room_title'] ? $v['room_title'] : '';
            $list[$k]['video_id'] = $v['video_id'];
            $list[$k]['nickname'] = $v['nickname'];
            $list[$k]['sex'] = $v['sex'];
            $list[$k]['ip'] = $v['ip'];
            $list[$k]['one_date'] = $v['one_date'];
            $list[$k]['new_date'] = $v['new_date'];
            $list[$k]['play_time'] = $v['play_time'];
            $list[$k]['openid'] = $v['openid'];
 
            $list[$k]['video_name'] = \backend\models\LiveSession::getName($v['video_id']);
            $list[$k]['sex_string'] = \backend\models\Params::$sex2[$v['sex']];
            $list[$k]['one_date_string'] = $v['one_date'] ? date('Y-m-d H:i:s',$v['one_date']) : '';
            $list[$k]['new_date_string'] = $v['new_date'] ? date('Y-m-d H:i:s',$v['new_date']) : '';
            $list[$k]['play_time_string'] = \common\components\CommonFunction::GetTime($v['play_time']);

        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;

 

 

    }

}