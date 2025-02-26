<?php

namespace backend\api\book;
use backend\models\Book;
use backend\models\BookCollect;
use backend\models\BookDetail;
use common\base\api\CommonApiAction;
use common\components\Helper;
use common\exception\ApiException;
use Yii;


class DetailAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {
        $id = $this->RequestData('id');
        $model = Book::findOne($id);
        if (!$model) {
            throw new ApiException('id不正确', 1);
        }
        $model->read_number++;
        $model->save();
        $book=BookDetail::find()->where(['book_id'=>$id])->orderBy('level asc,number1 asc,number2 asc')->all();
        $list=[];
        $number=[];
        foreach ($book as $k=>$v){
            if(!isset($list[$v['number1']])){
                $list[$v['number1']]=[
                    'id'=>$v['id'],
                    'title'=>$v['title'],
                    'number1'=>$v['number1'],
                    'number2'=>$v['number2'],
                    'list'=>[],
                ];
                $number[$v['number1']]=1;
            }else{
                $list[$v['number1']]['list'][]=[
                    'id'=>$v['id'],
                    'title'=>$v['title'],
                    'number1'=>$v['number1'],
                    'number2'=>    $number[$v['number1']],
                ];
                $number[$v['number1']]++;
            }
//            if($v['level']==1){
//                $list[$v->id]=[
//                    'id'=>$v['id'],
//                    'title'=>$v['title'],
//                    'number1'=>$v['number1'],
//                    'number2'=>$v['number2'],
//                    'list'=>[],
//                ];
//            }elseif($v['level']==2){
//                $list[$v->parent_id]['list'][]=[
//                    'id'=>$v['id'],
//                    'title'=>$v['title'],
//                    'number1'=>$v['number1'],
//                    'number2'=>$v['number2'],
//                ];
//            }
        }
        $collect=BookCollect::find()->where(['book_id'=>$id,'user_id'=>$this->user['id']])->limit(1)->one();
        if($collect){
            $is_collect=1;
        }else{
            $is_collect=0;
        }
        $list2=[];
        foreach ($list as $k=>$v){
            $list2[]=$v;
        }
        $jsonData['list']=$list2;
        $jsonData['detail']=Helper::model_message($model);
        $jsonData['detail']['info']=Helper::truncate_utf8_string($model->info,500);
        $jsonData['detail']['is_collect']=$is_collect;
        $jsonData['errmsg'] = '';
        return $jsonData;
    }

}