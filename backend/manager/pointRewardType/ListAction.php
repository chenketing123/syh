<?php

namespace backend\manager\pointRewardType;

use backend\models\PointRewardType;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\data\Pagination;

/**
 * @Class ListAction
 * @package backend\manager\pointRewardType
 * @User:五更的猫
 * @DateTime: 2023/12/13 14:11
 * @TODO 积分商品分类列表
 */
class ListAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $num = $this->RequestData('num',10);
        $page = $this->RequestData('page',1);

        $data=PointRewardType::find();

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
                'name' => $v['name'],
                'sort' => $v['sort'],
                'status' => $v['status'],
            );
        }

        $jsonData['list'] = $models;

        return $jsonData;
    }

}