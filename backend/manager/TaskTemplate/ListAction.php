<?php

namespace backend\manager\TaskTemplate;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\TaskTemplateSearch;
use yii\data\Pagination;
use backend\models\TaskTemplate;


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

 
        $data = TaskTemplate::find();
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
            $list[$k]['start_time'] = $v['start_time'];
            $list[$k]['end_time'] = $v['end_time'];
            $list[$k]['target_time'] = $v['target_time'];
            $list[$k]['statistics_time'] = $v['statistics_time'];
            $list[$k]['status'] = $v['status'];
            $list[$k]['get_data_ids'] = $v->getDataIds();
            $list[$k]['get_text_ids'] = $v->getTextIds();
            $list[$k]['is_send'] = $v['is_send'];
 
        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }
 



}