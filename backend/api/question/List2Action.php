<?php

namespace backend\api\question;
use backend\models\Question;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use Yii;


class List2Action extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {
        $page_number=$this->RequestData('page_number',10);
        $page=$this->RequestData('page',1);
        $type=$this->RequestData('type',2);
        $sort=$this->RequestData('sort',1);
        $category_id=$this->RequestData('category_id');
        $sort_message=[
            1=>'id desc',
            2=>'id asc',
            3=>'answer desc',
            4=>'answer asc',
            5=>'hit desc',
            6=>'hit asc',
        ];
        $sort_value=$sort_message[$sort];
        $search=$this->RequestData('search');
        $begin=($page-1)*$page_number;
        $query=Question::find()->where(['type'=>$type])->andFilterWhere(['like','content',$search]);
        if($category_id){
            $query->andWhere(['category_id'=>$category_id]);
        }
        $jsonData['total_pages']=ceil($query->count()/$page_number);
        $jsonData['total_count']=$query->count()*1;
        $model=$query->orderBy("$sort_value")->offset($begin)->limit($page_number)->all();
        $jsonData['list']=[];
        foreach ($model as $k=>$v){
            $jsonData['list'][]=[
                'id'=>$v['id'],
                'title'=>$v['title'],
                'content'=>$v['content'],
                'category_id'=>$v['category_id'],
                'category_id_title'=>$v['category']['title'],
                'hit'=>$v['hit'],
                'answer'=>$v['answer'],
                'created_at'=>date('Y-m-d',$v['created_at']),
                'like'=>$v['like'],
            ];
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }

}