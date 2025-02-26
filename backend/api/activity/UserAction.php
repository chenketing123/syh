<?php

namespace backend\api\activity;
use backend\models\Activity;
use backend\models\ActivityUser;
use backend\models\User;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\exception\ApiException;
use Yii;


class UserAction extends CommonApiAction
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

        $page_number=$this->RequestData('page_number',10);
        $page=$this->RequestData('page',1);
        $begin=($page-1)*$page_number;
        $query=ActivityUser::find()->where(['activity_id'=>$id]);
        $jsonData['total_count']=$query->count()*1;
        $jsonData['total_pages']=ceil($jsonData['total_count']/$page_number);
        $user=$query->offset($begin)->orderBy('id asc')->limit($page_number)->all();
        $jsonData['list']=[];

        foreach ($user as $k=>$v){
            $now=User::findOne($v['user_id']);
            if($now){
                $jsonData['list'][]=[
                    'name'=>$now['name'],
                    'image'=>CommonFunction::setImg($now['head_image']),
                ];
            }
        }
        $jsonData['errmsg'] = '';

        return $jsonData;
    }

}