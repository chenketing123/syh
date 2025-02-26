<?php
namespace api\controllers;
use Yii;
use yii\web\Response;


/**
 * Site controller
 */
class RoleController extends MController
{

    public function actions()
    {
        return [
            //操作授权详情
            'actions-details' => [
                'class' => 'backend\manager\role\ActionsDetailsAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //操作授权编辑
            'actions-edit' => [
                'class' => 'backend\manager\role\ActionsEditAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //菜单权限详情
            'menu-details' => [
                'class' => 'backend\manager\role\MenuDetailsAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //菜单权限编辑
            'menu-edit' => [
                'class' => 'backend\manager\role\MenuEditAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //添加
            'add' => [
                'class' => 'backend\manager\role\AddAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //删除
            'del' => [
                'class' => 'backend\manager\role\DelAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //详情
            'details' => [
                'class' => 'backend\manager\role\DetailsAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //编辑
            'edit' => [
                'class' => 'backend\manager\role\EditAction',
                'renderDataFormat' => Response::FORMAT_JSON,
            ],
            //列表
            'list' => [
                'class' => 'backend\manager\role\ListAction',
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
