<?php

namespace backend\api\user;
use backend\models\Question;
use backend\models\Task;
use backend\models\UserIcon;
use backend\models\UserMedal;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use Yii;



class QuestionAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $page_number=$this->RequestData('page_number',10);
        $page=$this->RequestData('page',1);
        $begin=($page-1)*$page_number;
        $query=Question::find()->where(['user_id'=>$this->user['id']]);
        $jsonData['total_pages']=ceil($query->count()/$page_number);
        $jsonData['total_count']=$query->count()*1;
        $model=$query->orderBy('id desc')->offset($begin)->limit($page_number)->all();
        $jsonData['list']=[];
        foreach ($model as $k=>$v){
            $jsonData['list'][]=[
                'id'=>$v['id'],
                'content'=>$v['content'],
                'head_image'=>CommonFunction::setImg($v['head_image']),
                'name'=>$v['name'],
                'category_id'=>$v['category_id'],
                'category_id_title'=>$v['category']['title'],
                'hit'=>$v['hit'],
                'answer'=>$v['answer'],
                'created_at'=>date('Y-m-d',$v['created_at'])
            ];
        }

        $jsonData['errmsg']='';
        return $jsonData;
    }
}