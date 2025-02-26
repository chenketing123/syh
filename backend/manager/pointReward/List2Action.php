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
class List2Action extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {
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

        $model = $data->orderBy('sort asc,id desc')->all();

        $models = array();

        foreach ($model as $k => $v) {
            $models[]=array(
                'key' => $v['id'],
                'value' => $v['name'],
            );
        }

        $jsonData['list'] = $models;

        return $jsonData;
    }

}