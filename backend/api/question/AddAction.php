<?php

namespace backend\api\question;
use backend\models\Question;
use backend\models\User;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\components\Weixin;
use common\exception\ApiException;
use Yii;


class AddAction extends CommonApiAction
{
    public $isSign=true;
    public $isLogin=true;

    protected function runAction()
    {

        $user_id=$this->user['id'];
        $user=User::findOne($user_id);
        $category_id=$this->RequestData('category_id');
        $content=$this->RequestData('content');
        if(!$category_id){
            throw new ApiException('请选择分类', 1);
        }
        if(!$content){
            throw new ApiException('请填写内容', 1);
        }

//        if($content){
//            $token=Weixin::Token();
//            $url="https://api.weixin.qq.com/wxa/msg_sec_check?access_token=$token";
//            $param=[
//                'content'=>mb_convert_encoding($content,'GBK','UTF-8'),
//                'version'=>2,
//                'scene'=>1,
//                'openid'=>$user['openid'],
//            ];
//            if($user['openid']){
//                $re=$this->curl2($param,$url);
//                $message_data=json_decode($re,true);
//                if($message_data['errcode']!=0){
//                    throw new ApiException('有非法内容',1);
//                }
//            }
//        }
        $new=new Question();
        $new->type=1;
        $new->user_id=$user->id;
        $new->content=$content;
        $new->category_id=$category_id;
        $new->head_image=$user->head_image;
        $new->name=$user->name;
        $new->company=$user->company;
        if(!$new->save()){
            throw new ApiException('提交失败', 1);
        }
        $jsonData['errmsg']='';
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