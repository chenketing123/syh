<?php
namespace api\controllers;
use yii\web\Response;


/**
 * Site controller
 */
class MessageController extends MController
{

    public function actions()
    {
        return [
            //接口地址
            'list' => [
                'class' => 'backend\api\message\ListAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'add' => [
                'class' => 'backend\api\message\AddAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

        ];
    }
}
