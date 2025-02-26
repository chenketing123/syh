<?php
namespace api\controllers;
use yii\web\Response;


/**
 * Site controller
 */
class UserController extends MController
{

    public function actions()
    {
        return [
            //接口地址


            'info' => [
                'class' => 'backend\api\user\InfoAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'update-base' => [
                'class' => 'backend\api\user\UpdateBaseAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'day' => [
                'class' => 'backend\api\user\DayAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'day2' => [
                'class' => 'backend\api\user\Day2Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'list' => [
                'class' => 'backend\api\user\ListAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'detail' => [
                'class' => 'backend\api\user\DetailAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'apply' => [
                'class' => 'backend\api\user\ApplyAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'media' => [
                'class' => 'backend\api\user\MedalAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],



            'question' => [
                'class' => 'backend\api\user\QuestionAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'question-delete' => [
                'class' => 'backend\api\user\QuestionDeleteAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            'activity' => [
                'class' => 'backend\api\user\ActivityAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'activity-detail' => [
                'class' => 'backend\api\user\ActivityDetailAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],



            'task' => [
                'class' => 'backend\api\user\TaskAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'add' => [
                'class' => 'backend\api\user\AddAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'message' => [
                'class' => 'backend\api\user\MessageAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'message-detail' => [
                'class' => 'backend\api\user\MessageDetailAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'check' => [
                'class' => 'backend\api\user\CheckAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


        ];
    }
}
