<?php

namespace backend\api\user;
use backend\models\UserIcon;
use backend\models\UserMedal;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use Yii;



class MedalAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {


        $user_id=$this->user['id'];
        $model=UserMedal::find()->where(['user_id'=>$user_id])->all();
        if(count($model)<=0){
            $message=UserIcon::find()->orderBy('sort asc,id desc')->all();
            foreach ($message as $k=>$v){
                $new=new UserMedal();
                $new->user_id=$user_id;
                $new->icon_id=$v['id'];
                $new->status=1;
                $new->save();
            }
        }
        $model=UserMedal::find()->where(['user_id'=>$user_id])->all();
        $jsonData['list']=[];
        foreach ($model as $k=>$v){
            $icon=UserIcon::findOne($v['icon_id']);
            if($v->status==1){
                $image=CommonFunction::setImg($icon['image2']);
            }else{
                $image=CommonFunction::setImg($icon['image']);
            }
            $jsonData['list'][]=[
                'title'=>$icon->title,
                'image'=>$image,
                'status'=>$v['status'],
            ];
        }
        $jsonData['errmsg']='';
        return $jsonData;
    }
}