<?php

namespace backend\manager\FixedTask;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\data\Pagination;
use backend\models\FixedTask;
use backend\search\FixedTaskLogSearch;
use backend\search\FixedTaskSearch;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class LogAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {
        $request  = Yii::$app->request;

        $fixed_task_id = $this->RequestData('fixed_task_id',0);
        $num = $this->RequestData('num',20);
        $page = $this->RequestData('page',1);

 
        $search = new FixedTaskLogSearch();
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
            $list[$k]['employee_name'] = $v['employee_name'];
            $list[$k]['type'] = $v['type'];
            $list[$k]['minimum'] = $v['minimum'];
            $list[$k]['punish'] = $v['punish'];
            $list[$k]['sprint1'] = $v['sprint1'];
            $list[$k]['sprint1_award'] = $v['sprint1_award'];
            $list[$k]['sprint2'] = $v['sprint2'];
            $list[$k]['sprint2_award'] = $v['sprint2_award'];
            $list[$k]['sprint3'] = $v['sprint3'];
            $list[$k]['sprint3_award'] = $v['sprint3_award'];
            $list[$k]['append'] = $v['append'];
 

            $list[$k]['type_string'] = \backend\models\FixedTaskLog::$type[$v->type];
            $list[$k]['append_string'] = date('Y-m-d H:i:s',$v->append);

        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }
 
 



}