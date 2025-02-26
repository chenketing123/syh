<?php

namespace backend\manager\user;

use backend\models\LoginForm;
use backend\models\Manager;
use backend\search\UserMap2Search;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class HighSeasAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {
        $request  = Yii::$app->request;

        $num = $this->RequestData('num',20);
        $page = $this->RequestData('page',1);


        $search = new UserMap2Search();
        $data = $search->search($request->get());
        $count = $data->count();
        $pageNum = ceil($count/$num);

        if($pageNum < $page && $pageNum != 0){
            throw new ApiException('分页过大',1);
        }
        $pages = new Pagination(['totalCount' => $count,'pageSize' =>$num, 'page'=>$page-1]);
        $models = $data->offset($pages->offset)->limit($pages->limit)->orderBy('u.id desc,u.created_at desc')->all();

        $list = array();
        foreach ($models as $k => $v) {
            $list[$k]['id'] = $v['id'];
            $list[$k]['head_portrait'] = $v->getImg();
            $list[$k]['nickname'] = $v['nickname'];
            $list[$k]['name'] = $v['name'];
            $list[$k]['sex'] = $v['sex'];
            $list[$k]['phone1'] = $v['phone1'] ? $v['phone1'] : '';
            $list[$k]['phone2'] = $v['phone2'] ? $v['phone2'] : '';
            $list[$k]['is_online'] = $v['is_online'];
            $list[$k]['is_offline'] = $v['is_offline'];
            $list[$k]['is_employee'] = $v['is_employee'];
            $list[$k]['last_ip'] = $v['last_ip'];
            $list[$k]['updated_at'] = $v['updated_at'];
            $list[$k]['last_time'] = $v['last_time'];
            $list[$k]['created_at'] = $v['created_at'];

            $list[$k]['sex_string'] = \backend\models\Params::$sex2[$v['sex']];
            $list[$k]['is_online_string'] = \backend\models\Params::$is[$v['is_online']];
            $list[$k]['is_offline_string'] = \backend\models\Params::$is[$v['is_offline']];
            $list[$k]['is_employee_string'] = \backend\models\Params::$is[$v['is_employee']];
            $list[$k]['updated_at_string'] = $v['updated_at'] ? Yii::$app->formatter->asDatetime($v['updated_at']) : '未设置';
            $list[$k]['last_time_string'] = $v['last_time'] ? Yii::$app->formatter->asDatetime($v['last_time']) : '未设置';
            $list[$k]['created_at_string'] = $v['created_at'] ? Yii::$app->formatter->asDatetime($v['created_at']) : '未设置';

        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }

}