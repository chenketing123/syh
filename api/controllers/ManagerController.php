<?php
namespace api\controllers;

use Yii;
use yii\web\Response;


/**
 * Site controller
 */
class ManagerController extends MController
{

    public function actions()
    {
        return [
            //删除账号
            'del' => [
                'class' => 'backend\manager\manager\DelAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //管理员详情
            'details' => [
                'class' => 'backend\manager\manager\DetailsAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //管理员列表
            'list' => [
                'class' => 'backend\manager\manager\ListAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //新增修改管理员
            'save' => [
                'class' => 'backend\manager\manager\SaveAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //错误地址
            'handler'=>[
                'class'=>'common\exception\ErrorApiAction',
                'renderDataFormat'=>Response::FORMAT_JSON
            ]
        ];
    }
}
