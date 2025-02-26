<?php

namespace backend\api\user;
use backend\models\Activity;
use backend\models\ActivityUser;
use backend\models\Book;
use backend\models\BookDetail;
use backend\models\Question;
use backend\models\Task;
use backend\models\Team;
use backend\models\User;
use backend\models\UserCheck;
use backend\models\UserIcon;
use backend\models\UserMedal;
use backend\models\UserTeam;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\components\Helper;
use Yii;



class CheckAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {




        $page_number=$this->RequestData('page_number',10);
        $page=$this->RequestData('page',1);
        $begin=($page-1)*$page_number;
        $query=UserCheck::find()->where(['user_id'=>$this->user['id'],'status'=>2]);
        $jsonData['total_pages']=ceil($query->count()/$page_number);
        $jsonData['total_count']=$query->count()*1;
        $model=$query->orderBy('check_time desc,id desc')->offset($begin)->limit($page_number)->all();
        $jsonData['list']=[];
        $user=User::findOne($this->user['id']);
        foreach ($model as $k=>$v){
            $team=Team::findOne($v['relation_id']);
            $user_team=UserTeam::find()->where(['user_id'=>$this->user['id'],'team_id'=>$v['relation_id']])->limit(1)->one();
            $user_type=1;
            if($user_team){
                $user_type=$user_team['user_type'];
            }

            $book=Book::findOne($v['book_id']);
            $detail=BookDetail::findOne($v['detail_id']);
            if($book and $detail){
                $arr_value=[];
                if($v['image']){
                    $arr_image=explode(',',$v['image']);
                    foreach ($arr_image as $k2=>$v2){
                        $arr_value[]=CommonFunction::setImg($v2);
                    }
                }
                $title=$book->title;
                if($detail['number1']>0){
                    $title.='第'.$detail['number1'].'章';
                }
                if($detail['number2']>0){
                    $title.='第'.$detail['number2'].'节';
                }
                $jsonData['list'][]=[
                    'id'=>$v['id'],
                    'book_image'=>Helper::imageUrl2($book['image']),
                    'book_title'=>$title,
                    'status'=>$v['status'],
                    'type'=>$v['type'],
                    'team_title'=>$team['title'],
                    'content'=>$v['content'],
                    'image'=>$arr_value,
                    'file'=>CommonFunction::setImg($v['file']),
                    'time'=>date('Y-m-d H:i',$v['check_time']),
                    'file_time'=>$v['file_time'],
                    'user_name'=>$user['name'],
                    'user_type'=>$user_type,
                    'head_image'=>CommonFunction::setImg($user['head_image']),
                ];
            }
        }

        $jsonData['errmsg']='';
        return $jsonData;
    }
}