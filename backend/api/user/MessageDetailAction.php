<?php

namespace backend\api\user;
use backend\models\SetImage;
use common\base\api\CommonApiAction;
use common\components\Helper;
use Yii;
use yii\base\BaseObject;


class MessageDetailAction extends CommonApiAction
{
    public $isSign=true;
//    public $isLogin=true;

    protected function runAction()
    {

        $id=$this->RequestData('id');
        $model=SetImage::findOne($id);
        if($model['type']==2){
            $type='系统消息';
        }else{
            $type='活动提醒';
        }
        if(isset($this->user['id'])){
            if($model['type']==2){
                $old=SetImage::find()->where(['type'=>98,'user_id'=>$this->user['id'],'realtion_id'=>$model['id']])->limit(1)->one();
                if(!$old){
                    $new=new SetImage();
                    $new->user_id=$this->user['id'];
                    $new->realtion_id=$model['id'];
                    $new->type=98;
                    $new->save();
                }
            }else{
                if($model['is_read']==0){
                    $model->is_read=1;
                    $model->save();
                }
            }
        }
        $jsonData['detail']=[
            'id'=>$model['id'],
            'title'=>$model['title'],
            'type'=>$type,
            'info'=>Helper::imageUrl($model['info'],Yii::$app->request->hostInfo),
            'time'=>date('Y年m月d日',$model['created_at']),

        ];

        $jsonData['errmsg']='';
        return $jsonData;
    }
}