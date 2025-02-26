<?php

namespace backend\manager\questionBank;

use backend\models\Params;
use backend\models\User;
use backend\search\QuestionBankSearch;
use backend\search\QuestionLogSearch;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use yii\data\Pagination;

/**
 * @Class LogListAction
 * @package backend\manager\questionBank
 * @User:五更的猫
 * @DateTime: 2023/12/14 8:59
 * @TODO 答题记录
 */
class LogListAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $num = $this->RequestData('num',10);
        $page = $this->RequestData('page',1);
        $room_id = $this->RequestData('room_id',null);
        $activity_id = $this->RequestData('activity_id',null);
        $session_id = $this->RequestData('session_id',null);
        $user_id = $this->RequestData('user_id',null);
        $is_pass = $this->RequestData('is_pass',null);
        $is_award = $this->RequestData('is_award',null);
        $keywords = $this->RequestData('keywords',null);

        $search = new QuestionLogSearch();
        $searchData = array(
            'room_id'=>$room_id,
            'keywords' => $keywords,
            'activity_id'=>$activity_id,
            'session_id'=>$session_id,
            'user_id'=>$user_id,
        );
        if(!empty($status)){
            $searchData['status'] = $status;
        }
        if(!empty($is_pass)){
            $searchData['is_pass'] = $is_pass;
        }
        if(!empty($is_award)){
            $searchData['is_award'] = $is_award;
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
        $is = Params::$is;
        $userArr = array();
        foreach ($model as $k => $v) {
            if(!isset($userArr[$v['user_id']])){
                $userArr[$v['user_id']] = User::getName($v['user_id']);
            }
            $v->content = json_decode($v->content,true);
            $v->answer = json_decode($v->answer,true);

            $answer = array();

            foreach ($v->content as $v2){
                $content = array();
                foreach ($v2['content'] as $v3){
                    $content[]=array(
                        'title'=>$v3,
                        'is_checked'=>in_array($v3,$v->answer[$v2['id']])?1:0,
                        'is_correct'=>in_array($v3,$v2['answer'])?1:0,
                    );
                }
                $answer[]=array(
                    'id'=>$v2['id'],
                    'title'=>$v2['title'],
                    'type'=>$v2['type'],
                    'content'=>$content,
                );
            }

            $models[]=array(
                'id' => $v['id'],
                'room_title' => $v['room_title'],
                'activity_title' => $v['activity_title'],
                'session_title' => $v['session_title'],
                'user_id' => $v['user_id'],
                'user_text' => $userArr[$v['user_id']],
                'is_pass' => $v['is_pass'],
                'is_pass_text' => $is[$v['is_pass']],
                'is_award' => $v['is_award'],
                'is_award_text' => $is[$v['is_award']],
                'award_name' => $v->getAwardName(),
                'date' => date('Y-m-d H:i:s',$v['append']),
                'answer' => $answer,
            );
        }

        $jsonData['list'] = $models;

        return $jsonData;
    }

}