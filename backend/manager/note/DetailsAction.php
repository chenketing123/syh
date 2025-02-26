<?php

namespace backend\manager\note;

use backend\models\LiveActivity;
use backend\models\LiveRoom;
use backend\models\LiveSession;
use backend\models\Note;
use backend\models\User;
use common\base\api\ApiAction;
use common\base\api\ManagerApiAction;
use common\components\CommonFunction;
use common\exception\ApiException;
use Yii;

/**
 * @Class DetailsAction
 * @package backend\manager\pointRewardType
 * @User:五更的猫
 * @DateTime: 2023/12/13 15:15
 * @TODO 客户笔记详情
 */
class DetailsAction extends ManagerApiAction
{
    public $isLogin = true;
    protected function runAction()
    {

        $id = $this->RequestData('id',null);

        if(empty($id)){
            throw new ApiException('请选择客户笔记',1);
        }
        $model = Note::findOne($id);
        if(empty($model)){
            throw new ApiException('未找到此客户笔记记录',1);
        }

        $images_log = array();

        foreach (unserialize($model->images_log) as $v){
            $images_log[]=CommonFunction::setImg($v);
        }

        $jsonData = array(
            'id'=>$model->id,
            'user_id' => $model->user_id,
            'user_text' => User::getName($model->user_id),
            'room_id' => $model->room_id,
            'room_text' => LiveRoom::getName($model->room_id),
            'activity_id' => $model->activity_id,
            'activity_text' => LiveActivity::getName($model->activity_id),
            'session_id' => $model->session_id,
            'title' => $model->title,
            'images' => CommonFunction::setImg($model->images),
            'images_log' => $images_log,
            'name' => $model->name,
            'phone' => $model->phone,
            'price' => $model->price,
            'is_open' => $model->is_open,
            'status' => $model->status,
            'status_text' => Note::$status[$model->status],
            'remark' => $model->remark,
            'content' => $model->content,
            'video' => CommonFunction::setImg($model->video),
        );

        return $jsonData;
    }

}