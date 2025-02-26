<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id'                   => 'app-backend',
    'basePath'             => dirname(__DIR__),
    'controllerNamespace'  => 'backend\controllers',
    'defaultRoute'         => 'main',//默认控制器
    'bootstrap'            => ['log'],
    'modules' => [
        'gridview' => [
            'class' => 'kartik\grid\Module'
        ],
        'treemanager' =>  [
            'class' => '\kartik\tree\Module',
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'backend\models\Manager',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        /**-------------------错误定向页-------------------**/
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        /**-------------------RBAC配置-------------------**/
        'authManager' => [
            'class'             => 'yii\rbac\DbManager',
            'itemTable'         => '{{%auth_item}}',
            'assignmentTable'   => '{{%auth_assignment}}',
            'itemChildTable'    => '{{%auth_item_child}}',
        ],

        /**-------------------后台操作日志-------------------**/
        'actionlog' => [
            'class' => 'backend\models\ActionLog',
        ],


    ],


    'params' => $params,
];
