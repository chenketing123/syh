<?php

namespace backend\api\question;
use backend\models\Like;
use backend\models\Question;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\exception\ApiException;
use Yii;


class Detail2Action extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $id=$this->RequestData('id');
        $model=Question::findOne($id);
        if(!$model){
            throw new ApiException('id不正确', 1);
        }
        $model->hit++;
        $is_like=0;
        $model->save();
        $old=Like::find()->where(['type'=>1,'question_id'=>$id,'user_id'=>$this->user['id']])->limit(1)->one();
        if($old){
            $is_like=1;
        }
        $jsonData['detail']=[
            'id'=>$model['id'],
            'category_id_title'=>$model['category']['title'],
            'content'=>$model['content'],
            'name'=>$model['name'],
            'head_image'=>CommonFunction::setImg($model['head_image']),
            'created_at'=>date('Y-m-d',$model['created_at']),
            'is_like'=>$is_like,
            'like'=>$model['like'],
            'position'=>$model['position'],
            'title'=>$model['title']
        ];

        $jsonData['errmsg']='';
        return $jsonData;
    }

}