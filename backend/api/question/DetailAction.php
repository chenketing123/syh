<?php

namespace backend\api\question;
use backend\models\Question;
use backend\models\QuestionAnswer;
use backend\models\User;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\exception\ApiException;
use Yii;


class DetailAction extends CommonApiAction
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
        if($model->status!=2){
            throw new ApiException('该问题未通过审核', 1);
        }
        $model->hit++;
        $model->save();
        $answer=QuestionAnswer::find()->where(['question_id'=>$id])->all();
        $arr=[];
        foreach ($answer as $k=>$v){
            $arr[]=[
                'content'=>$v['content'],
                'created_at'=>date('Y-m-d',$v['created_at']),
                'name'=>$v['name'],
                'position'=>$v['position'],
                'head_image'=>CommonFunction::setImg($v['head_image']),
            ];
        }
        $user=User::findOne($this->user['id']);
        $jsonData['detail']=[
            'id'=>$model['id'],
            'company'=>$model['company'],
            'answer'=>$model['answer'],
            'category_id_title'=>$model['category']['title'],
            'content'=>$model['content'],
            'name'=>$model['name'],
            'head_image'=>CommonFunction::setImg($model['head_image']),
            'created_at'=>date('Y-m-d',$model['created_at']),
            'message'=>$arr,
            'is_answer'=>$user['is_answer'],
        ];

        $jsonData['errmsg']='';
        return $jsonData;
    }

}