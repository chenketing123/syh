<?php
namespace api\controllers;

use common\components\Helper;
use common\components\Weixin;
use common\exception\ApiException;
use Yii;
use yii\web\Response;


/**
 * Site controller
 */
class CommonController extends MController
{

    public function actions()
    {
        return [
            //登录
            'password-login' => [
                'class' => 'backend\manager\common\PasswordLoginAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'login' => [
                'class' => 'backend\api\common\LoginAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'openid' => [
                'class' => 'backend\api\common\OpenidAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            'openid2' => [
                'class' => 'backend\api\common\Openid2Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'login2' => [
                'class' => 'backend\api\common\Login2Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'login3' => [
                'class' => 'backend\api\common\Login3Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'code' => [
                'class' => 'backend\api\common\CodeAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'register' => [
                'class' => 'backend\api\common\RegisterAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //错误地址
            'handler'=>[
                'class'=>'common\exception\ErrorApiAction',
                'renderDataFormat'=>Response::FORMAT_JSON
            ],

            //上传文件
            'up-files' => [
                'class' => 'backend\api\common\UpFilesAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'up-files3' => [
                'class' => 'backend\api\common\UpFiles3Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],



            'up-files2' => [
                'class' => 'backend\api\common\UpFilesAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //上传图片
            'up-image' => [
                'class' => 'backend\api\common\UpImageAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            'address'=>[
                'class' => 'backend\api\common\ProvincesAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'address2'=>[
                'class' => 'backend\api\common\Address2Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            'city'=>[
                'class' => 'backend\api\common\City2Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            'daochu'=>[
                'class' => 'backend\api\common\DaochuAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'add-accident'=>[
                'class' => 'backend\api\common\AddAccidentAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'accident-list'=>[
                'class' => 'backend\api\common\AccidentListAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'log'=>[
                'class' => 'backend\api\common\LogAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],





        ];
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
