<?php

namespace backend\api\user;
use backend\models\Book;
use backend\models\BookDetail;
use backend\models\UserCheck;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\components\Helper;
use common\exception\ApiException;
use Yii;



class DetailAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {


        $id=$this->RequestData('id');
        $model=UserCheck::findOne($id);
        if(!$model){
            throw new ApiException('id不正确', 1);
        }
        $detail=BookDetail::findOne($model['detail_id']);
        if(!$detail){
            throw new ApiException('发生错误', 1);
        }
        $book=Book::findOne($model['book_id']);
        if(!$book){
            throw new ApiException('发生错误', 1);
        }
//        $title=$book->title;
//        if($detail['number1']>0){
//            $title.='第'.$detail['number1'].'章';
//        }
//        if($detail['number2']>0){
//            $title.='第'.$detail['number2'].'节';
//        }
        $title=$detail['title'];
        $arr_value=[];
        $arr_image=explode(',',$model['image']);
        foreach ($arr_image as $k=>$v){
            $arr_value[]=CommonFunction::setImg($v);
        }
        $user_task=[
            'content'=>$model['content'],
            'image'=>implode(',',$arr_value),
            'file'=>CommonFunction::setImg($model['file']),
            'time'=>date('Y-m-d H:i',$model['check_time']),
            'file_time'=>$model['file_time'],
        ];
        $jsonData['detail']=[
            'title'=>$title,
            'author'=>$book['author'],
            'category_id'=>$book['category_id'],
            'category_id_title'=>$book['category']['title'],
            'image'=>Helper::imageUrl2($book['image']),
            'content'=>$detail['content'],
            'status'=>$model['status'],
            'user_task'=>$user_task,
        ];

        $jsonData['errmsg']='';
        return $jsonData;
    }
}