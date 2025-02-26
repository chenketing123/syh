<?php

namespace backend\manager\AwardQuota;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\AwardQuotaSearch;
use yii\data\Pagination;
use backend\models\AwardQuota;


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

 
        $search = new AwardQuotaSearch();
        $data=$search->search($request->get());
        $count = $data->count();
        $pageNum = ceil($count/$num);

        if($pageNum < $page && $pageNum != 0){
            throw new ApiException('分页过大',1);
        }
        $pages = new Pagination(['totalCount' => $count,'pageSize' =>$num, 'page'=>$page-1]);
        $models = $data->select('aq.*,u.openid,u.phone,u.nickname,u.name')->offset($pages->offset)->limit($pages->limit)->orderBy('id desc')->asArray()->all();

        $list = array();
        foreach ($models as $k => $v) {
            $list[$k]['id'] = $v['id'];
            $list[$k]['room_id'] = $v['room_id'];
            $list[$k]['code'] = $v['code'];
            $list[$k]['openid'] = $v['openid'] ? $v['openid'] : '';
            $list[$k]['nickname'] = $v['nickname'] ? $v['nickname'] : '';
            $list[$k]['name'] = $v['name'] ? $v['name'] : '';
            $list[$k]['phone'] = $v['phone'] ? $v['phone'] : '';
            $list[$k]['number'] = $v['number'];
 
            $list[$k]['room_name'] = \backend\models\LiveRoom::getName($v['room_id']);

        }

        $jsonData['list'] = $list;
        $jsonData['page_num'] = $pageNum;
        $jsonData['count'] = $count;

        return $jsonData;
    }

 
 





}