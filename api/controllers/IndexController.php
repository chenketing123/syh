<?php

namespace api\controllers;
use backend\models\ActionLog;
use backend\models\Activity;
use backend\models\ActivityUser;
use backend\models\Goods;
use backend\models\Order;
use backend\models\Sku;
use common\base\api\CommonApiAction;
use common\components\CommonFunction;
use common\components\Helper;
use common\components\Pay;
use common\components\Weixin;
use common\components\WxApi;
use common\exception\ApiException;
use yii\base\BaseObject;
use yii\base\Object;
use yii\helpers\Url;
use yii\web\Response;


/**
 * Site controller
 */
class IndexController extends MController
{

    public function actions()
    {
        return [
            //接口地址
            'add-log' => [
                'class' => 'backend\api\video\AddLog2Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //错误地址
            'handler' => [
                'class' => 'common\exception\ErrorApiAction',
                'renderDataFormat' => Response::FORMAT_JSON
            ],
            'add-image' => [
                'class' => 'backend\api\common\UpImageAction',
                'renderDataFormat' => Response::FORMAT_JSON
            ],
            'home' => [
                'class' => 'backend\api\common\HomeAction',
                'renderDataFormat' => Response::FORMAT_JSON
            ],


            'message' => [
                'class' => 'backend\api\common\MessageAction',
                'renderDataFormat' => Response::FORMAT_JSON
            ],


        ];
    }







    public function actionWx(){

        $str='<xml><return_code><![CDATA[FAIL]]></return_code><return_msg><![CDATA[签名失败]]></return_msg></xml>';
        $xml =  file_get_contents('php://input');

        //将服务器返回的XML数据转化为数组
        $data =$this->xml_to_data($xml);


        $data_sign = $data['sign'];
        // sign不参与签名算法
        unset($data['sign']);
        $sign = $this->makeSign($data);
        // 判断签名是否正确  判断支付状态
        if ( ($sign===$data_sign) && ($data['return_code']=='SUCCESS') && ($data['result_code']=='SUCCESS') ) {
            $pay=ActivityUser::findOne(['order_number'=>$data['out_trade_no']]);
            if($pay and $pay->pay_status==1){
                if($pay->price*100-$data['total_fee']<=0.01){
                    $pay->pay_status=2;
                    $pay->paid_time=time();
                    $pay->save();
                    $str='<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';

                }
            }
        }

        echo $str;
    }





    public function MakeSign( $params ){
//签名步骤一：按字典序排序数组参数
        ksort($params);
        $string = $this->ToUrlParams($params);
//签名步骤二：在string后加入KEY
        $string = $string . "&key=33028219960830555117764528723xxt";
//签名步骤三：MD5加密
        $string = md5($string);
//签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }


    public function xml_to_data($xml){
        if(!$xml){
            return false;
        }
//将XML转为array
//禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $data;
    }





    public function ToUrlParams( $params ){
        $string = '';
        if( !empty($params) ){
            $array = array();
            foreach( $params as $key => $value ){
                $array[] = $key.'='.$value;
            }
            $string = implode("&",$array);
        }
        return $string;
    }







}
