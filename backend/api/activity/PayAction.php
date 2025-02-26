<?php

namespace backend\api\activity;
use backend\models\ActivityUser;
use backend\models\User;
use common\base\api\CommonApiAction;
use common\components\Pay;
use common\exception\ApiException;
use Yii;
use yii\helpers\Url;


class PayAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {
        $order_id = $this->RequestData('order_id');
        $user=User::findOne($this->user['id']);
        if(!$user['openid']){
            throw new ApiException('openid未获取', 1);
        }
        $model = ActivityUser::findOne($order_id);
        if (!$model or $model['user_id']!=$this->user['id']) {
            throw new ApiException('id不正确', 1);
        }

        $status=$model->pay_status;

        if($status==1 and $model->price<=0){
            $status=2;
        }
        $jsonData['errmsg'] = '';
        $order_number=date('YmdHis').$user->id.mt_rand(100,999);
        $model->order_number=$order_number;
        $model->save();
        if(!$user->openid){
            throw new ApiException('没有openid', 1);
        }

        $notify_url=Yii::$app->request->getHostInfo().Url::to(['index/wx']);
        if($status==1){
            $new=Pay::WxJsPay('活动支付',$order_number,$model->price,$notify_url,$user->openid);
            $data_value=json_decode($new,true);
            $jsonData['detail']=[
                'status'=>$status,
                'timeStamp'=>$data_value['timeStamp'],
                'nonceStr'=>$data_value['nonceStr'],
                'package'=>$data_value['package'],
                'signType'=>$data_value['signType'],
                'paySign'=>$data_value['paySign'],

            ];
        }else{

            $jsonData['detail']=[
                'status'=>$status,
                'timeStamp'=>'',
                'nonceStr'=>'',
                'package'=>'',
                'signType'=>'',
                'paySign'=>'',

            ];
        }

        return $jsonData;
    }

}