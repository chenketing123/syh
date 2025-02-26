<?php
namespace api\controllers;
use yii\web\Response;


/**
 * Site controller
 */
class ServerController extends MController
{

    public function actions()
    {
        return [
            //接口地址
            'list' => [
                'class' => 'backend\api\server\ListAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            'detail' => [
                'class' => 'backend\api\server\DetailAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            'add' => [
                'class' => 'backend\api\server\AddAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'update' => [
                'class' => 'backend\api\server\UpdateAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            'delete' => [
                'class' => 'backend\api\server\DeleteAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

        ];
    }
}
