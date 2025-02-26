<?php

namespace backend\api\common;
use backend\models\User;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use Yii;


class MessageAction extends CommonApiAction
{


    protected function runAction()
    {
        $arr=[
            'message'=>Yii::$app->config->info('MESSAGE'),
            'register'=>Yii::$app->config->info('REGISTER'),
            'video'=>CommonFunction::setImg(Yii::$app->config->info('VIDEO')),
            'image'=>CommonFunction::setImg(Yii::$app->config->info('Image')),
            'mobile'=>Yii::$app->config->info('WEB_SITE_MOBILE'),
        ];

        $type=$this->RequestData('type','message');
        if($type=='video'){
            if(Yii::$app->config->info('VIDEO')){
                $jsonData['data']=CommonFunction::setImg(Yii::$app->config->info('VIDEO'));
                $jsonData['type']='video';
            }else{
                $jsonData['data']=CommonFunction::setImg(Yii::$app->config->info('IMAGE'));
                $jsonData['type']='image';
            }
        }else{
            $jsonData['data']=$arr[$type];
        }

        $jsonData['errmsg']='';
        return $jsonData;
    }

}