<?php
namespace api\controllers;

use api\controllers\MController;
use Yii;
use yii\web\Response;


/**
 * Site controller
 */
class ConfigController extends MController
{

    public function actions()
    {
        return [
            //配置
            'config' => [
                'class' => 'backend\manager\config\ConfigAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //列表
            'list' => [
                'class' => 'backend\manager\config\ListAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //修改
            'edit' => [
                'class' => 'backend\manager\config\EditAction',
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
