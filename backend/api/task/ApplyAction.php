<?php

namespace backend\api\task;
use backend\models\Task;
use backend\models\TaskUser;
use backend\models\User;
use common\base\api\CommonApiAction;
use common\exception\ApiException;
use Yii;


class ApplyAction extends CommonApiAction
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
        $old=TaskUser::find()->where(['task_id'=>$id,'user_id'=>$this->user['id']])->limit(1)->one();
        if($old){
            throw new ApiException('您已经完成该作业', 1);
        }else{
            $content=$this->RequestData('content','');
            $image=$this->RequestData('image','');
            $file=$this->RequestData('file','');
            if(!$content and !$file and !$image){
                throw new ApiException('内容 图片 录音 至少提交一个', 1);
            }
            $new=new TaskUser();
            $new->user_id=$this->user['id'];
            $new->content=$content;
            $new->file=$file;
            $new->image=$image;
            $new->task_id=$id;
            $new->file_time=$this->RequestData('file_time');
            if(!$new->save()){
                $errors=$new->getFirstErrors();
                throw new ApiException(reset($errors), 1);
            }
            $user=User::findOne($this->user['id']);
            $user->task+=1;
            $user->save();
        }

        $jsonData['errmsg'] = '';
        return $jsonData;
    }

}