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


class Read2Action extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {
        $id=$this->RequestData('id',1);
        $type=$this->RequestData('type',1);
        $detail=BookDetail::findOne($id);
        if(!$detail){
            throw new ApiException('id不正确', 1);
        }
        if($type==1){
            $arr=[
                'id'=>$detail['id'],
                'content'=>Helper::imageUrl($detail['content'],Yii::$app->request->hostInfo),
                'book_id'=>$detail['book_id'],
                'title'=>$detail['title'],
                'number1'=>$detail['number1'],
                'number2'=>$detail['number2'],
            ];
            $jsonData['detail']=$arr;
            $jsonData['errmsg']='';
        }elseif ($type==2){
            $before=BookDetail::find()->where(['book_id'=>$detail['book_id'],'number1'=>$detail['number1']])
                ->andWhere(['<','number2',$detail['number2']])->orderBy('number2 desc')->limit(1)->one();
            if($before){
                if(!$before['content'] and $before['number2']==0){
                    $before=BookDetail::find()->where(['book_id'=>$detail['book_id']])
                        ->andWhere(['<','number1',$detail['number1']])
                        ->orderBy('number1 desc,number2 desc')->limit(1)->one();
                    if(!$before){
                        throw new ApiException('没有上一章了', 1);
                    }
                }
                $arr=[
                    'id'=>$before['id'],
                    'content'=>Helper::imageUrl($before['content'],Yii::$app->request->hostInfo),
                    'book_id'=>$before['book_id'],
                    'title'=>$before['title'],
                    'number1'=>$before['number1'],
                    'number2'=>$before['number2'],
                ];

            }else{

                $before=BookDetail::find()->where(['book_id'=>$detail['book_id']])
                    ->andWhere(['<','number1',$detail['number1']])
                   ->orderBy('number1 desc,number2 desc')->limit(1)->one();
                if(!$before){
                    throw new ApiException('没有上一章了', 1);
                }else{
                    $arr=[
                        'id'=>$before['id'],
                        'content'=>Helper::imageUrl($before['content'],Yii::$app->request->hostInfo),
                        'book_id'=>$before['book_id'],
                        'title'=>$before['title'],
                        'number1'=>$before['number1'],
                        'number2'=>$before['number2'],
                    ];
                }
            }
        }elseif ($type==3){
            $after=BookDetail::find()->where(['book_id'=>$detail['book_id'],'number1'=>$detail['number1']])
                ->andWhere(['>','number2',$detail['number2']])->orderBy('number2 asc')->limit(1)->one();
            if($after){
                $arr=[
                    'id'=>$after['id'],
                    'content'=>Helper::imageUrl($after['content'],Yii::$app->request->hostInfo),
                    'book_id'=>$after['book_id'],
                    'title'=>$after['title'],
                    'number1'=>$after['number1'],
                    'number2'=>$after['number2'],
                ];
            }else{

                $after=BookDetail::find()->where(['book_id'=>$detail['book_id']])
                    ->andWhere(['>','number1',$detail['number1']])
                    ->orderBy('number1 asc,number2 asc')->limit(1)->one();
                if(!$after){
                    throw new ApiException('已经是最后一章了', 1);
                }else{
                    if(!$after['content'] and $after['number2']==0){
                        $after=BookDetail::find()->where(['book_id'=>$detail['book_id']])
                            ->andWhere(['>','number1',$detail['number1']])
                            ->andWhere(['>=','number2',1])
                            ->orderBy('number1 asc,number2 asc')->limit(1)->one();
                        if(!$after){
                            throw new ApiException('已经是最后一章了', 1);
                        }
                    }

                    $arr=[
                        'id'=>$after['id'],
                        'content'=>Helper::imageUrl($after['content'],Yii::$app->request->hostInfo),
                        'book_id'=>$after['book_id'],
                        'title'=>$after['title'],
                        'number1'=>$after['number1'],
                        'number2'=>$after['number2'],
                    ];
                }
            }
        }else{
            throw new ApiException('发生错误', 1);
        }

        BookRead::deleteAll(['book_id'=>$arr['book_id'],'user_id'=>$this->user['id']]);
        $collect=BookCollect::find()->where(['book_id'=>$arr['book_id'],'user_id'=>$this->user['id']])->limit(1)->one();
        if($collect){
            $is_collect=1;
        }else{
            $is_collect=0;
        }
        $new=new BookRead();
        $new->book_id=$arr['book_id'];
        $new->detail_id=$arr['id'];
        $new->number1=$arr['number1'];
        $new->number2=$arr['number2'];
        $new->user_id=$this->user['id'];
        $new->save();
        $jsonData['detail']=$arr;
        $jsonData['detail']['is_collect']=$is_collect;
        $jsonData['errmsg']='';
        return $jsonData;
    }

}