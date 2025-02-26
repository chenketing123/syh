<?php

namespace backend\manager\LiveRoom;

use backend\models\LoginForm;
use backend\models\Manager;
use common\base\api\ManagerApiAction;
use common\exception\ApiException;
use Yii;
use backend\search\UserSearch;
use yii\data\Pagination;
use common\components\CommonFunction;
use backend\models\LiveRoom;


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
        $title = $this->RequestData('title','');
        $cover = $this->RequestData('cover','');
        $cover2 = $this->RequestData('cover2','');
        $cover3 = $this->RequestData('cover3',0);
        $cover4 = $this->RequestData('cover4','');
        $app_cover = $this->RequestData('app_cover','');
        $share_title = $this->RequestData('share_title','');
        $share_desc = $this->RequestData('share_desc','');
        $share_img = $this->RequestData('share_img','');
        $url = $this->RequestData('url','');
        $code = $this->RequestData('code','');
        $goods_id = $this->RequestData('goods_id',0);
        $intro = $this->RequestData('intro','');
        $live_time = $this->RequestData('live_time',0);
        $full_count = $this->RequestData('full_count',0);
        $full2_count = $this->RequestData('full2_count',0);
        $buy_give_number = $this->RequestData('buy_give_number',0);
        $sort = $this->RequestData('sort',10);
        $status = $this->RequestData('status',1);
        $is_open_note = $this->RequestData('is_open_note',2);
        $is_send_point = $this->RequestData('is_send_point',2);


        if(empty($title)){
            throw new ApiException('名称不能为空',1);
        }
        if(empty($code)){
            throw new ApiException('识别码不能为空',1);
        }
        if(empty($goods_id)){
            throw new ApiException('产品不能为空',1);
        }
        if(empty($url)){
            throw new ApiException('域名不能为空',1);
        }

 
  
        $model = LiveRoom::findOne($id);
        if(empty($model)){
            $model = new LiveRoom();
        }
        $model->title = $title;
        $model->cover = CommonFunction::unsetImg($cover);
        $model->cover2 = CommonFunction::unsetImg($cover2);
        $model->cover3 = CommonFunction::unsetImg($cover3);
        $model->cover4 = CommonFunction::unsetImg($cover4);
        $model->app_cover = CommonFunction::unsetImg($app_cover);
        $model->share_title = $share_title;
        $model->share_desc = $share_desc;
        $model->share_img = CommonFunction::unsetImg($share_img);
        $model->url = $url;
        $model->code = $code;
        $model->goods_id = $goods_id;
        $model->intro = $intro;
        $model->live_time = $live_time;
        $model->full_count = $full_count;
        $model->full2_count = $full2_count;
        $model->buy_give_number = $buy_give_number;
        $model->sort = $sort;
        $model->status = $status;
        $model->is_open_note = $is_open_note;
        $model->is_send_point = $is_send_point;

        if(!$model->save()){
            $error = $model->getErrors();
            $error = reset($error);
            throw new ApiException(reset($error),1);
        }

        $jsonData['id'] = $model->id;

        return $jsonData;


    }

}