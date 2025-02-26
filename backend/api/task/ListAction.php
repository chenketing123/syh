<?php

namespace backend\api\task;
use backend\models\SetImage;
use backend\models\Task;
use backend\models\TaskUser;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use Yii;


class ListAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {
        $page_number=$this->RequestData('page_number',10);
        $page=$this->RequestData('page',1);
        $begin=($page-1)*$page_number;
        $query=Task::find();
        $jsonData['total_pages']=ceil($query->count()/$page_number);
        $jsonData['total_count']=$query->count()*1;
        $model=$query->orderBy('sort asc,id desc')->offset($begin)->limit($page_number)->all();
        $jsonData['list']=[];
        $banner=SetImage::getOne(['type'=>4]);
        foreach ($model as $k=>$v){
            $status=1;
            $old=TaskUser::find()->where(['user_id'=>$this->user['id'],'task_id'=>$v['id']])->limit(1)->one();
            if($old){
                $status=2;
            }
            $jsonData['list'][]=[
                'id'=>$v['id'],
                'title'=>$v['title'],
                'start_time'=>date('Y-m-d',$v['start_time']),
                'end_time'=>date('Y-m-d',$v['end_time']),
                'image'=>CommonFunction::setImg($v['image']),
                'status'=>$status,
            ];
        }
        $jsonData['banner']=CommonFunction::setImg($banner['image']);
        $jsonData['errmsg']='';
        return $jsonData;
    }

}