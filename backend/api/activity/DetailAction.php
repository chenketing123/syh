<?php

namespace backend\api\activity;
use backend\models\Activity;
use backend\models\ActivityUser;
use backend\models\User;
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
        $id = $this->RequestData('id');
        $model = Activity::findOne($id);
        if (!$model) {
            throw new ApiException('id不正确', 1);
        }

        $user=ActivityUser::find()->where(['activity_id'=>$id])->orderBy('id asc')->all();
        $arr_user=[];
        $user_status=0;
        foreach ($user as $k=>$v){
            if($v['user_id']==$this->user['id']){
                $user_status=1;

            }
            $now=User::findOne($v['user_id']);

            if($now){
                $arr_user[]=[
                    'name'=>$now['name'],
                    'image'=>CommonFunction::setImg($now['head_image']),
                ];
            }
        }
        $recommend=Activity::find()->where(['status'=>1])->andWhere(['<>','id',$id])->orderBy('sort asc,id desc')->limit(5)->all();


        $arr_recommend=[];
        foreach ($recommend as $k=>$v){
            $arr_recommend[]=[
                'id'=>$v['id'],
                'title'=>$v['title'],
                'start_time'=>date('m-d H:i',$v['start_time']),
                'end_time'=>date('m-d H:i',$v['end_time']),
                'image'=>CommonFunction::setImg($v['image']),
                'number'=>$v['number'],
                'status'=>$v['status'],
                'address'=>$v['address']
            ];
        }
        if($model['price']==0){
            $model['price']='公益免费';
        }
        $jsonData['detail']=[
            'id'=>$model['id'],
            'title'=>$model['title'],
            'start_time'=>date('m-d H:i',$model['start_time']),
            'end_time'=>date('m-d H:i',$model['end_time']),
            'image'=>CommonFunction::setImg($model['image']),
            'number'=>$model['number'],
            'status'=>$model['status'],
            'address'=>$model['address'],
            'price'=>$model['price'],
            'content'=>Helper::imageUrl($model['content'],Yii::$app->request->hostInfo),
            'info'=>Helper::imageUrl($model['info'],Yii::$app->request->hostInfo),
            'user'=>$arr_user,
            'user_status'=>$user_status,
            'recommend'=>$arr_recommend,
            'type'=>$model['type'],
            'appid'=>'wx34b0738d0eef5f78',
            'path'=>'/'.$model['path']
        ];
        $jsonData['errmsg'] = '';
        return $jsonData;
    }

}