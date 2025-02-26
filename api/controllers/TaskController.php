<?php
namespace api\controllers;
use yii\web\Response;


/**
 * Site controller
 */
class TaskController extends MController
{

    public function actions()
    {
        return [
            //接口地址
            'list' => [
                'class' => 'backend\api\task\ListAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'detail' => [
                'class' => 'backend\api\task\DetailAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'apply' => [
                'class' => 'backend\api\task\ApplyAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

        ];
    }
}
