<?php
namespace api\controllers;
use yii\web\Response;


/**
 * Site controller
 */
class QuestionController extends MController
{

    public function actions()
    {
        return [
            //接口地址
            'list' => [
                'class' => 'backend\api\question\ListAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'list2' => [
                'class' => 'backend\api\question\List2Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'category' => [
                'class' => 'backend\api\question\CategoryAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'detail' => [
                'class' => 'backend\api\question\DetailAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'detail2' => [
                'class' => 'backend\api\question\Detail2Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'add' => [
                'class' => 'backend\api\question\AddAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'answer' => [
                'class' => 'backend\api\question\AnswerAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'like' => [
                'class' => 'backend\api\question\LikeAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


        ];
    }
}
