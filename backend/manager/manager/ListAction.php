<?php

namespace backend\manager\manager;

use backend\search\ManagerSearch;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\data\Pagination;

/**
 * @Class ListAction
 * @package backend\manager\manager
 * @User:五更的猫
 * @DateTime: 2023/12/22 9:27
 * @TODO 管理员列表
 */
class ListAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $num = $this->RequestData('num',10);
        $page = $this->RequestData('page',1);
        $keywords = $this->RequestData('keywords',null);
        $role_id = $this->RequestData('role_id',null);
        $sex = $this->RequestData('sex',null);

        $search = new ManagerSearch();
        $searchData = array(
            'keywords'=>$keywords,
        );
        if(!empty($sex)){
            $searchData['sex'] = $sex;
        }
        if(!empty($role_id)){
            $searchData['role_id'] = $role_id;
        }
        $data=$search->search($searchData);

        $count = $data->count();

        $pageNum = ceil($count/$num);

        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;
        if($pageNum<$page && $pageNum != 0){
            throw new ApiException('分页过大',1);
        }
        $pages = new Pagination(['totalCount' => $count,'pageSize' =>$num, 'page'=>$page-1]);
        $model = $data->offset($pages->offset)->limit($pages->limit)->orderBy('id desc')->all();

        $models = array();

        foreach ($model as $k => $v) {
            $models[]=array(
                'id' => $v['id'],
                'head_portrait' => $v->getImg(),
                'role_name' => $v->getRoleName(),
                'username' => $v['username'],
                'realname' => $v['realname'],
                'mobile_phone' => $v['mobile_phone'],
                'email' => $v['email'],
                'visit_count' => $v['visit_count'],
                'last_ip' => $v['last_ip'],
                'date' => empty($v['last_time'])?'未登录':date('Y-m-d H:i:s',$v['last_time']),
            );
        }

        $jsonData['list'] = $models;
        $jsonData['errmsg'] = '';
        return $jsonData;
    }

}