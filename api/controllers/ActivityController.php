<?php
namespace api\controllers;
use yii\web\Response;


/**
 * Site controller
 */
class ActivityController extends MController
{

    public function actions()
    {
        return [
            //接口地址
            'list' => [
                'class' => 'backend\api\activity\ListAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'list2' => [
                'class' => 'backend\api\activity\List2Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'detail' => [
                'class' => 'backend\api\activity\DetailAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'user' => [
                'class' => 'backend\api\activity\UserAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'apply' => [
                'class' => 'backend\api\activity\ApplyAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'pay' => [
                'class' => 'backend\api\activity\PayAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],



            'check' => [
                'class' => 'backend\api\activity\CheckAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'check-message' => [
                'class' => 'backend\api\activity\CheckMessageAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

        ];
    }
}
