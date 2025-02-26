<?php
namespace backend\api\common;
use backend\models\Code;
use backend\models\User;
use common\base\api\ApiAction;
use common\components\Helper;
use common\exception\ApiException;
use Yii;

class CodeAction extends ApiAction
{

    public $isSign=true;
    protected function runAction()
    {
        $mobile=$this->RequestData('mobile');
        if(!$mobile){
            throw new ApiException('电话号码不能为空', 1);
        }
            $model = Code::find()->where(['phone' => $mobile])->one();
            $number = rand(10000, 99999);
        if (count($model) > 0) {

            if ((time() - $model['create_time']) <= 60) {

                throw new ApiException('短信发送太频繁，请等待1分钟', 1);


            } else {

                $model['number'] = $number;

                $model['phone'] = "$mobile";

                $model['expire_time'] = time() + 300;

                $model['create_time'] = time();

            }

        } else {

            $model = new Code();

            $model['number'] = $number;

            $model['phone'] = "$mobile";

            $model['expire_time'] = time() + 300;

            $model['create_time'] = time();

        }

        if ($model->save()) {



            $re = Helper::phpSendMessage($mobile, $number);

            if ($re) {

                $data['error'] = 0;

            } else {

                throw new ApiException('发送失败', 1);
            }

        } else {

            throw new ApiException('发送失败', 1);

        }






        $jsonData['errmsg']='';
        return $jsonData;
    }



}