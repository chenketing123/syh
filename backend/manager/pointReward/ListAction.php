<?php

namespace backend\manager\pointReward;

use backend\models\PointRewardType;
use backend\search\PointRewardSearch;
use common\base\api\ManagerApiAction;
use common\components\CommonFunction;
use common\exception\ApiException;
use Yii;
use yii\data\Pagination;

/**
 * @Class ListAction
 * @package backend\manager\pointRewardType
 * @User:五更的猫
 * @DateTime: 2023/12/13 14:11
 * @TODO 积分商品列表
 */
class ListAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $num = $this->RequestData('num',10);
        $page = $this->RequestData('page',1);
        $type_id = $this->RequestData('type_id',null);
        $status = $this->RequestData('status',null);
        $keywords = $this->RequestData('keywords',null);

        $search = new PointRewardSearch();
        $searchData = array(
            'type_id'=>$type_id,
            'keywords' => $keywords,
        );
        if(!empty($status)){
            $searchData['status'] = $status;
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
        $model = $data->offset($pages->offset)->limit($pages->limit)->orderBy('sort asc,id desc')->all();

        $models = array();
        $typeArr = array();

        foreach ($model as $k => $v) {
            if(!isset($typeArr[$v['type_id']])){
                $typeArr[$v['type_id']] = PointRewardType::getName($v['type_id']);
            }

            $models[]=array(
                'id' => $v['id'],
                'type_id' => $v['type_id'],
                'type_text' => $typeArr[$v['type_id']],
                'name' => $v['name'],
                'cover' => CommonFunction::setImg($v['cover']),
                'price' => $v['price'],
                'point' => $v['point'],
                'sort' => $v['sort'],
                'status' => $v['status'],
            );
        }

        $jsonData['list'] = $models;

        return $jsonData;
    }

}