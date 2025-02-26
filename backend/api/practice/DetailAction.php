<?php

namespace backend\api\practice;
use backend\models\Practice;
use backend\models\PracticeCategory;
use backend\models\PracticeUser;
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
        $model=Practice::findOne($id);
        if (!$model) {
            throw new ApiException('id不正确', 1);
        }
        $task_message=PracticeUser::find()->where(['user_id'=>$this->user['id'],'practice_id'=>$model['id']])->limit(1)->one();
        $status=1;
        $user_task=[];
        if($task_message){
            $status=2;
            $arr_value=[];
            if($task_message['image']){
                $arr_image=explode(',',$task_message['image']);
                foreach ($arr_image as $k=>$v){
                    $arr_value[]=CommonFunction::setImg($v);
                }
            }else{
                $arr_value="";
            }

            $user_task=[
                'content'=>$task_message['content'],
                'image'=>$arr_value,
                'file'=>CommonFunction::setImg($task_message['file']),
                'time'=>date('Y-m-d H:i',$task_message['created_at']),
                'file_time'=>$task_message['file_time']
            ];
        }


        $category=PracticeCategory::findOne($model['category_id']);
        $title2='';
        if($category->parent_id>0){
            $category2=PracticeCategory::findOne($category['parent_id']);
            $title2=$category2['title'];
        }
        $jsonData['detail']=[
            'id'=>$model['id'],
            'title'=>$model['title'],
            'category1'=>$category['title'],
            'category2'=>$title2,
            'start_time'=>date('Y-m-d',$model['start_time']),
            'end_time'=>date('Y-m-d',$model['end_time']),
            'image'=>CommonFunction::setImg($model['image']),
            'user_task'=>$user_task,
            'status'=>$status,
            'content'=>Helper::imageUrl2($model['content'])
        ];
        $jsonData['errmsg']='';
        return $jsonData;
    }

}