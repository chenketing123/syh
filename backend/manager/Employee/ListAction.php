<?php

namespace backend\manager\Employee;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\EmployeeSearch;
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

 
        $search = new EmployeeSearch();
        $data = $search->search($request->get());
        $count = $data->count();
        $pageNum = ceil($count/$num);
 
        if($pageNum < $page && $pageNum != 0){
            throw new ApiException('分页过大',1);
        }
        $pages = new Pagination(['totalCount' => $count,'pageSize' =>$num, 'page'=>$page-1]);
        $models = $data->offset($pages->offset)->orderBy('id desc')->limit($pages->limit)->all();

        $list = array();
        foreach ($models as $k => $v) {


            $list[$k]['id'] = $v['id'];
            $list[$k]['name'] = $v['name'];
            $list[$k]['mobile'] = $v['mobile'];
            $list[$k]['position'] = $v['position'];
            $list[$k]['gender'] = $v['gender'];
            $list[$k]['email'] = $v['email'];
            $list[$k]['avatar'] = $v->getImg();
            $list[$k]['alias'] = $v['alias'];
            $list[$k]['status'] = $v['status'];
            $list[$k]['qr_code'] = $v['qr_code'];
            $list[$k]['main_department'] = $v['main_department'];
            $list[$k]['is_leader'] = $v['is_leader'];
            $list[$k]['market'] = $v['market'];
            $list[$k]['is_blacklist'] = $v['is_blacklist'];

            
            $list[$k]['department_name'] = $v->GetDepartment();
            $list[$k]['gender_string'] = \backend\models\Params::$sex2[$v['gender']];
            $list[$k]['status_string'] = \backend\models\Employee::$status[$v['status']];
            $list[$k]['main_department_string'] = \backend\models\Department::getName($v->main_department);
            $list[$k]['is_leader_string'] = \backend\models\Params::$is[$v['is_leader']];
            $list[$k]['market_string'] = \backend\models\Market::getName($v->market);
            $list[$k]['is_blacklist_string'] = \backend\models\Params::$is[$v->is_blacklist];

            
 


        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }

}