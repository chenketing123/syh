<?php

namespace backend\manager\Activity;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\Activity;


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
        $name = $this->RequestData('name','');
        $cover = $this->RequestData('cover','');
        $apply_start_time = $this->RequestData('apply_start_time','');
        $apply_end_time = $this->RequestData('apply_end_time','');
        $start_time = $this->RequestData('start_time','');
        $end_time = $this->RequestData('end_time','');
        $address = $this->RequestData('address','');
        $type = $this->RequestData('type',1);
        $content = $this->RequestData('content','');
        $limit = $this->RequestData('limit',0);
        $sort = $this->RequestData('sort',10);
        $status = $this->RequestData('status',1);

 


        if(empty($name)){
            throw new ApiException('旅游名称不能为空',1);
        }
        if(empty($apply_start_time)){
            throw new ApiException('报名开始时间不能为空',1);
        }
        if(empty($apply_end_time)){
            throw new ApiException('报名结束时间不能为空',1);
        }
        if(empty($start_time)){
            throw new ApiException('活动开始时间不能为空',1);
        }
        if(empty($end_time)){
            throw new ApiException('活动结束时间不能为空',1);
        }
        if(empty($address)){
            throw new ApiException('旅游地点不能为空',1);
        }

 

 
  
        $model = Activity::findOne($id);
        if(empty($model)){
            $model = new Activity();
        }
        $model->name = $name;
        $model->cover = CommonFunction::unsetImg($cover);
        $model->apply_start_time = $apply_start_time;
        $model->apply_end_time = $apply_end_time;
        $model->start_time = $start_time;
        $model->end_time = $end_time;
        $model->address = $address;
        $model->type = $type;
        $model->content = $content;
        $model->limit = $limit;
        $model->sort = $sort;
        $model->status = $status;
  
 

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;


    }

}