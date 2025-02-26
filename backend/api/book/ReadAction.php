<?php

namespace backend\api\book;
use backend\models\Book;
use backend\models\BookCollect;
use backend\models\BookDetail;
use backend\models\BookRead;
use common\base\api\CommonApiAction;
use common\components\Helper;
use common\exception\ApiException;
use Yii;


class ReadAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {


        $id=$this->RequestData('id');
        $book=Book::findOne($id);
        if(!$book){
            throw new ApiException('id不正确', 1);
        }

        $old=BookRead::find()->where(['user_id'=>$this->user['id'],'book_id'=>$id])->orderBy('id desc')->limit(1)->one();
        $collect=BookCollect::find()->where(['book_id'=>$id,'user_id'=>$this->user['id']])->limit(1)->one();
        if($collect){
            $is_collect=1;
        }else{
            $is_collect=0;
        }

        if($old){
            $detail=BookDetail::findOne($old['detail_id']);
            if($detail){
                $arr=[
                    'id'=>$detail['id'],
                    'content'=>Helper::imageUrl($detail['content'],Yii::$app->request->hostInfo),
                    'book_id'=>$detail['book_id'],
                    'title'=>$detail['title'],
                    'number1'=>$detail['number1'],
                    'number2'=>$detail['number2'],
                ];
                $jsonData['detail']=$arr;
                $jsonData['detail']['is_collect']=$is_collect;
                $jsonData['errmsg']='';
                return $jsonData;
            }
        }
        $detail=BookDetail::find()->where(['number1'=>1,'book_id'=>$id])->andWhere(['<=','number2',1])->orderBy('number2 desc')->limit(1)->one();
        if($detail){
            $arr=[
                'id'=>$detail['id'],
                'content'=>Helper::imageUrl($detail['content'],Yii::$app->request->hostInfo),
                'book_id'=>$detail['book_id'],
                'title'=>$detail['title'],
                'number1'=>$detail['number1'],
                'number2'=>$detail['number2'],
            ];
        }else{
            throw new ApiException('发生错误', 1);
        }


        $jsonData['detail']=$arr;
        $jsonData['detail']['is_collect']=$is_collect;
        $jsonData['errmsg']='';
        return $jsonData;
    }

}