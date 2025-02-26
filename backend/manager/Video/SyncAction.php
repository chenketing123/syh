<?php

namespace backend\manager\Video;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\Video;
use backend\models\LiveSession;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class SyncAction extends ManagerApiAction
{
    protected function runAction()
    {

        $id = $this->RequestData('id',0);
 
        
        $model = Video::findOne($id);
        if(empty($model)){
            throw new ApiException('没有此视频',1);
        }
        if($model->session_id==0){
            throw new ApiException('此视频不是同步视频',1);
        }
        $sessionModel = LiveSession::findOne(['id'=>$model->session_id]);
        if(empty($sessionModel)){
            throw new ApiException('同步视频不存在',1);
        }
 

 

        $model->room_id = $sessionModel['room_id'];
        $model->name = $sessionModel['name'];
        $model->url = $sessionModel['url'];
        $model->cover = $sessionModel['cover'];
        $model->yz_id = $sessionModel['yz_id'];

        $model->year = $sessionModel['year'];
        $model->month = $sessionModel['month'];
        $model->province = $sessionModel['province'];
        $model->city = $sessionModel['city'];
        $model->district = $sessionModel['district'];
        $model->street = $sessionModel['street'];

        if($model->save()){

        }else{
            throw new ApiException('同步失败',1);
        }


 


    }


 
 



}