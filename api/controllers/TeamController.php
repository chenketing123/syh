<?php
namespace api\controllers;
use yii\web\Response;


/**
 * Site controller
 */
class TeamController extends MController
{

    public function actions()
    {
        return [
            //接口地址



            'list' => [
                'class' => 'backend\api\team\ListAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'add' => [
                'class' => 'backend\api\team\AddAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'check-mobile' => [
                'class' => 'backend\api\team\CheckMobileAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'update' => [
                'class' => 'backend\api\team\UpdateAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'list2' => [
                'class' => 'backend\api\team\List2Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'list3' => [
                'class' => 'backend\api\team\List3Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'team' => [
                'class' => 'backend\api\team\TeamAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            'group' => [
                'class' => 'backend\api\team\GroupAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'user' => [
                'class' => 'backend\api\team\UserAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'user2' => [
                'class' => 'backend\api\team\User2Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'update-user' => [
                'class' => 'backend\api\team\UpdateUserAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'delete' => [
                'class' => 'backend\api\team\DeleteAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'tongji' => [
                'class' => 'backend\api\team\TongjiAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],

            'tongji2' => [
                'class' => 'backend\api\team\Tongji2Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'daochu' => [
                'class' => 'backend\api\team\DaochuAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],


            'daochu2' => [
                'class' => 'backend\api\team\Daochu2Action',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],



        ];
    }
}
