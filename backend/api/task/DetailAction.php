<?php

namespace backend\api\task;
use backend\models\Task;
use backend\models\TaskUser;
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
        $id = $this->RequestData('id');
        $model = Task::findOne($id);
        if (!$model) {
            throw new ApiException('id不正确', 1);
        }
        $user=User::findOne($this->user['id']);
        if($user->is_vip==0){
            throw new ApiException('非会员无法查看', 1);
        }
        $user_task=[];
        $task_message=TaskUser::find()->where(['task_id'=>$id,'user_id'=>$this->user['id']])->limit(1)->one();
        if($task_message){
            $arr_value=[];
            $arr_image=explode(',',$task_message['image']);
            foreach ($arr_image as $k=>$v){
                $arr_value[]=CommonFunction::setImg($v);
            }
            $user_task=[
                'content'=>$task_message['content'],
                'image'=>implode(',',$arr_value),
                'file'=>CommonFunction::setImg($task_message['file']),
                'time'=>date('Y-m-d H:i',$task_message['created_at']),
                'file_time'=>$task_message['file_time'],
            ];
        }
        $status=1;
        if($task_message){
            $status=2;
        }
        if($model['type']==1){
            $video=CommonFunction::setImg($model['video']);
            $type='video';
        }else{
            $video=CommonFunction::setImg($model['image']);
            $type='image';
        }
        $jsonData['detail']=[
            'id'=>$model['id'],
            'title'=>$model['title'],
            'start_time'=>date('Y-m-d',$model['start_time']),
            'end_time'=>date('Y-m-d',$model['end_time']),
            'image'=>CommonFunction::setImg($model['image']),
            'video'=>$video,
            'user_task'=>$user_task,
            'status'=>$status,
            'type'=>$model['type']

        ];
        $jsonData['errmsg'] = '';
        return $jsonData;
    }

}