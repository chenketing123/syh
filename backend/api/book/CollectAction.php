<?php

namespace backend\api\book;
use backend\models\BookCollect;
use common\base\api\CommonApiAction;
use Yii;


class CollectAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {
        $id = $this->RequestData('id');

        $user_id=$this->user['id'];
        $old=BookCollect::find()->where(['user_id'=>$user_id,'book_id'=>$id])->limit(1)->one();
        if($old){
            $old->delete();
        }else{
            $new=new BookCollect();
            $new->user_id=$user_id;
            $new->book_id=$id;
            $new->save();
        }
        $jsonData['errmsg'] = '';
        return $jsonData;
    }

}