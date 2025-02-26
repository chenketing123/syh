<?php

namespace backend\manager\UserArchives;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use backend\search\UserArchivesSearch;
use yii\data\Pagination;


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

 
        $search = new UserArchivesSearch();
        $data = $search->search($request->get());
        $count = $data->count();
        $pageNum = ceil($count/$num);

        if($pageNum < $page && $pageNum != 0){
            throw new ApiException('分页过大',1);
        }
        $pages = new Pagination(['totalCount' => $count,'pageSize' =>$num, 'page'=>$page-1]);
        $models = $data->offset($pages->offset)->orderBy('id desc')->limit($pages->limit)->select('ua.*,u.is_online,u.is_offline')->asArray()->all();

        $list = array();
        foreach ($models as $k => $v) {
            $list[$k]['id'] = $v['id'];
            $list[$k]['name'] = $v['name'];
            $list[$k]['sex'] = $v['sex'];
            $list[$k]['phone1'] = $v['phone1'] ? $v['phone1'] : '';
            $list[$k]['phone2'] = $v['phone2'] ? $v['phone2'] : '';
            $list[$k]['is_online'] = $v['is_online'];
            $list[$k]['is_offline'] = $v['is_offline'];
            $list[$k]['age'] = $v['age'] ? $v['age'] : '';
            $list[$k]['id_number'] = $v['id_number'] ? $v['id_number'] : '';
 

            $list[$k]['sex_string'] = \backend\models\Params::$sex2[$v['sex']];
            $list[$k]['is_online_string'] = \backend\models\Params::$is[$v['is_online']];
            $list[$k]['is_offline_string'] = \backend\models\Params::$is[$v['is_offline']];
 
            

        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }

}