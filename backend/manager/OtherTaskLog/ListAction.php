<?php

namespace backend\manager\OtherTaskLog;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\data\Pagination;
use backend\models\OtherTaskLog;
use backend\search\OtherTaskLogSearch;
use common\components\CommonFunction;


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

 
        $search = new OtherTaskLogSearch();
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
            $list[$k]['type'] = $v['type'];
            $list[$k]['user_name'] = $v['user_name'];
            $list[$k]['content'] = $v['content'];
            $list[$k]['append'] = $v['append'];
 

            $list[$k]['type_string'] = \backend\models\OtherTaskLog::$type[$v->type];
            $list[$k]['get_files'] = $v->getFiles();
            $list[$k]['append_string'] = date('Y-m-d H:i:s',$v->append);

            if(count($list[$k]['get_files'])){
                foreach($list[$k]['get_files'] as $kk => $vv){
                    $list[$k]['get_files'][$kk] = CommonFunction::setImg($vv);
                }
            }
        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }
 
 



}