<?php

namespace backend\manager\LiveSession;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\LiveSession;


/**
 * @Class PasswordLoginAction
 * @package backend\manager\common
 * @User:五更的猫
 * @DateTime: 2023/11/2 14:49
 * @TODO 密码登录
 */
class EditAction extends ManagerApiAction
{
    protected function runAction()
    {

        $id = $this->RequestData('id',0);
        $room_id = $this->RequestData('room_id',0);
        $activity_id = $this->RequestData('activity_id',0);
        $name = $this->RequestData('name','');
        $cover = $this->RequestData('cover','');
        $url = $this->RequestData('url','');
        $yz_id = $this->RequestData('yz_id','');
        $content = $this->RequestData('content','');
        $is_playback = $this->RequestData('is_playback',1);
        $end_stat_date = $this->RequestData('end_stat_date','');
        $staff_end_stat_date = $this->RequestData('staff_end_stat_date','');
        $play_date = $this->RequestData('play_date','');
        $year = $this->RequestData('year',2023);
        $month = $this->RequestData('month',1);
        $province = $this->RequestData('province',0);
        $city = $this->RequestData('city',0);
        $district = $this->RequestData('district',0);
        $street = $this->RequestData('street',0);
        $customer_name = $this->RequestData('customer_name','');
        $keyword = $this->RequestData('keyword','');
        $entity1 = $this->RequestData('entity1','');
        $entity2 = $this->RequestData('entity2','');
        $sort = $this->RequestData('sort',10);
        $status = $this->RequestData('status',1);

        $note_point = $this->RequestData('note_point',0);
        $is_question = $this->RequestData('is_question',2);
        $question_ids = $this->RequestData('question_ids',array());
        $question_point = $this->RequestData('question_point',0);

        if(empty($room_id)){
            throw new ApiException('直播间不能为空',1);
        }
        if(empty($activity_id)){
            throw new ApiException('直播活动不能为空',1);
        }
        if(empty($name)){
            throw new ApiException('活动名称不能为空',1);
        }
        if(empty($url)){
            throw new ApiException('播放链接不能为空',1);
        }
        $question_ids = is_array($question_ids)?$question_ids:explode(',',$question_ids);

  
        $model = LiveSession::findOne($id);
        if(empty($model)){
            $model = new LiveSession();
        }
        $model->room_id = $room_id;
        $model->activity_id = $activity_id;
        $model->name = $name;
        $model->year = $year;
        $model->month = $month;
        $model->cover = CommonFunction::unsetImg($cover);
        $model->url = $url;
        $model->yz_id = $yz_id;
        $model->content = $content;
        $model->is_playback = $is_playback;
        $model->end_stat_date = $end_stat_date;
        $model->staff_end_stat_date = $staff_end_stat_date;
        $model->play_date = $play_date;
        $model->province = $province;
        $model->city = $city;
        $model->district = $district;
        $model->street = $street;
        $model->customer_name = $customer_name;
        $model->keyword = $keyword;
        $model->entity1 = $entity1;
        $model->entity2 = $entity2;
        $model->sort = $sort;
        $model->status = $status;

        $model->note_point = $note_point;
        $model->is_question = $is_question;
        $model->question_ids = $question_ids;
        $model->question_point = $question_point;

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;


    }

}