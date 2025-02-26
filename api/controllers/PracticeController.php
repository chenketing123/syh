<?php
namespace api\controllers;
use yii\web\Response;


/**
 * Site controller
 */
class PracticeController extends MController
{

    public function actions()
    {
        return [
            //接口地址
            'category' => [
                'class' => 'backend\api\practice\CategoryAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'children' => [
                'class' => 'backend\api\practice\ChildrenAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'detail' => [
                'class' => 'backend\api\practice\DetailAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'list' => [
                'class' => 'backend\api\practice\ListAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'apply' => [
                'class' => 'backend\api\practice\ApplyAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],




        ];
    }
}
