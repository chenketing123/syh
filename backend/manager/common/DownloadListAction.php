<?php

namespace backend\manager\common;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\DownloadSearch;
use yii\data\Pagination;
use backend\models\Download;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class DownloadListAction extends ManagerApiAction
{
    public $isLogin = true;

    protected function runAction()
    {

        //  $search->user_id = Yii::$app->user->identity->id;
 
 

        $request  = Yii::$app->request;

        $num = $this->RequestData('num',20);
        $page = $this->RequestData('page',1);

 
        $search = new DownloadSearch();
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
            $list[$k]['user_id'] = $v['user_id'];
            $list[$k]['type'] = $v['type'];
            $list[$k]['files'] = $v['files'] ? \Yii::$app->request->hostInfo.$v['files'] : '';
            $list[$k]['status'] = $v['status'];
            $list[$k]['append'] = $v['append'];
            $list[$k]['updated'] = $v['updated'];
 
 
            $list[$k]['status_string'] = \backend\models\Download::$status[$v['status']];
            $list[$k]['type_string'] = \backend\models\Download::$type[$v['type']];
            $list[$k]['updated_string'] = $v['updated'] ? Yii::$app->formatter->asDatetime($v['updated']) : '';
            $list[$k]['append_string'] = $v['append'] ? Yii::$app->formatter->asDatetime($v['append']) : '';

        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;



    }

}