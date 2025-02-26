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
        $name = $this->RequestData('name','');
        $cover = $this->RequestData('cover','');
        $url = $this->RequestData('url','');
        $yz_id = $this->RequestData('yz_id','');
        $content = $this->RequestData('content','');
        $sort = $this->RequestData('sort',10);
        $status = $this->RequestData('status',1);
        $year = $this->RequestData('year',0);
        $month = $this->RequestData('month',1);
        $day = $this->RequestData('day',1);
        $province = $this->RequestData('province',0);
        $city = $this->RequestData('city',0);
        $district = $this->RequestData('district',0);
        $street = $this->RequestData('street',0);
        $entity = $this->RequestData('entity','');
        $user = $this->RequestData('user','');
        $type2 = $this->RequestData('type2',0);
        $remark = $this->RequestData('remark','');

        
 



        if(empty($room_id)){
            throw new ApiException('直播间不能为空',1);
        }
        if(empty($name)){
            throw new ApiException('视频名称不能为空',1);
        }
        if(empty($url)){
            throw new ApiException('播放链接不能为空',1);
        }
 

 

 
  
        $model = Video::findOne($id);
        if(empty($model)){
            $model = new Video();
        }
        $model->room_id = $room_id;
        $model->name = $name;
        $model->cover = CommonFunction::unsetImg($cover);
        $model->url = $url;
        $model->yz_id = $yz_id;
        $model->content = $content;
        $model->sort = $sort;
        $model->status = $status;
        $model->year = $year;
        $model->month = $month;
        $model->day = $day;
        $model->province = $province;
        $model->city = $city;
        $model->district = $district;
        $model->street = $street;
        $model->entity = $entity;
        $model->user = $user;
        $model->type2 = $type2;
        $model->remark = $remark;

 

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;


    }


 
 



}