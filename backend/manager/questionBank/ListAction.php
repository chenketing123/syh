<?php

namespace backend\manager\questionBank;

use backend\models\QuestionBank;
use backend\search\QuestionBankSearch;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\data\Pagination;

/**
 * @Class ListAction
 * @package backend\manager\questionBank
 * @User:五更的猫
 * @DateTime: 2023/12/13 16:40
 * @TODO 答题库列表
 */
class ListAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $num = $this->RequestData('num',10);
        $page = $this->RequestData('page',1);
        $status = $this->RequestData('status',null);
        $type = $this->RequestData('type',null);
        $keywords = $this->RequestData('keywords',null);

        $search = new QuestionBankSearch();
        $searchData = array(
            'type'=>$type,
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
        $typeArr = QuestionBank::$type;
        foreach ($model as $k => $v) {
            $models[]=array(
                'id' => $v['id'],
                'name' => $v['title'],
                'type' => $v['type'],
                'type_text' => $typeArr[$v['type']],
                'sort' => $v['sort'],
                'status' => $v['status'],
            );
        }

        $jsonData['list'] = $models;

        return $jsonData;
    }

}