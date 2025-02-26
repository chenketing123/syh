<?php

namespace backend\api\user;
use backend\models\User;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\components\Helper;
use common\components\Weixin;
use common\exception\ApiException;
use Yii;


class UpdateBaseAction extends CommonApiAction
{
    public $isSign = true;
    public $isLogin = true;

    protected function runAction()
    {

        $user_id=$this->user['id'];
        $user=User::findOne($user_id);
        if($this->RequestData('name')){
            $user->name=$this->RequestData('name');
//            $token=Weixin::Token();
//            $url="https://api.weixin.qq.com/wxa/msg_sec_check?access_token=$token";
//            $param=[
//                'content'=>mb_convert_encoding($this->RequestData('name'),'GBK','UTF-8'),
//                'version'=>2,
//                'scene'=>1,
//                'openid'=>$user['openid'],
//            ];
//            $re=$this->curl2($param,$url);
//            $message_data=json_decode($re,true);
//            if($message_data['errcode']!=0){
//                throw new ApiException('昵称中有非法内容',1);
//            }
        }
        if($this->RequestData('head_image')){
            $user->head_image=$this->RequestData('head_image');
        }
        if($this->RequestData('sex')){
            $user->sex=$this->RequestData('sex');
        }
        if($this->RequestData('company')){
            $user->company=$this->RequestData('company');
        }
        if($this->RequestData('company_image')){
            $user->company_image=CommonFunction::unsetImg($this->RequestData('company_image'));
        }

        if($this->RequestData('business')){
            $user->business=$this->RequestData('business');
        }
        if($this->RequestData('age')){
            $user->age=$this->RequestData('age');
        }

        if(!$user->save()){
            $errors=$user->getFirstErrors();
            throw new ApiException(reset($errors), 1);
        }
        $jsonData['errmsg'] = '';
        return $jsonData;
    }

    public function curl2($param = '', $url, $type = 1)
    {

        $postUrl = $url;

        $curlPost = json_encode($param);

        $ch = curl_init();                                      //初始化curl

        curl_setopt($ch, CURLOPT_URL, $postUrl);                 //抓取指定网页

        curl_setopt($ch, CURLOPT_HEADER, 0);                    //设置header

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            //要求结果为字符串且输出到屏幕上
        if ($type == 1) {
            curl_setopt($ch, CURLOPT_POST, 1);
        }//post提交方式

        $headers = [
            'Content-Type: application/json',
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);           // 增加 HTTP Header（头）里的字段

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        // 终止从服务端进行验证

        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        $data = curl_exec($ch);                                 //运行curl
        curl_close($ch);

        return $data;

    }


}