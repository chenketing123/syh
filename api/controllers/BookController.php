<?php
namespace api\controllers;
use yii\web\Response;


/**
 * Site controller
 */
class BookController extends MController
{

    public function actions()
    {
        return [
            //接口地址
            'list' => [
                'class' => 'backend\api\book\ListAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'list2' => [
                'class' => 'backend\api\book\List2Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'detail' => [
                'class' => 'backend\api\book\DetailAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'collect' => [
                'class' => 'backend\api\book\CollectAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'my' => [
                'class' => 'backend\api\book\MyAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'read' => [
                'class' => 'backend\api\book\ReadAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'read2' => [
                'class' => 'backend\api\book\Read2Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

        ];
    }
}
