<?php

namespace backend\api\book;
use backend\models\Book;
use backend\models\BookCollect;
use backend\models\BookRead;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use Yii;


class MyAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $page_number=$this->RequestData('page_number',10);
        $page=$this->RequestData('page',1);
        $begin=($page-1)*$page_number;
        $query=BookCollect::find()->where(['user_id'=>$this->user['id']]);
        $jsonData['total_pages']=ceil($query->count()/$page_number);
        $jsonData['total_count']=$query->count()*1;
        $model=$query->orderBy('id desc')->offset($begin)->limit($page_number)->all();
        $jsonData['list']=[];
        foreach ($model as $k=>$v){


            $book=Book::findOne($v['book_id']);
            if($book){
                $arr['id']=$v['book_id'];
                $arr['title']=$book['title'];
                $arr['author']=$book['author'];
                $arr['image']=CommonFunction::setImg($book['image']);
                $read=BookRead::find()->where(['user_id'=>$this->user['id']])->orderBy('id desc')->limit(1)->one();
                if($read){
                    $arr['read_book']=$read['number1'];
                }else{
                    $arr['read_book']=1;
                }
                $jsonData['list'][]=$arr;
            }



        }
        $jsonData['errmsg']='';
        return $jsonData;
    }

}