<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath'      => dirname(__DIR__),
    'bootstrap'     => ['log'],
    'controllerNamespace' => 'api\controllers',
    'defaultRoute'         => 'index',//默认控制器
    'components' => [
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => true,
        ],
        'session' => [
            'name' => 'advanced-api',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['java_api'],
                    'levels' => ['error', 'warning'],
                    'logVars' => ['*'],
                    'logFile' => '@runtime/logs/java_api.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['api_data2'],
                    'levels' => ['error', 'warning'],
                    'logVars' => ['*'],
                    'logFile' => '@runtime/logs/api_data2.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['get_java_api'],
                    'levels' => ['error', 'warning'],
                    'logVars' => ['*'],
                    'logFile' => '@runtime/logs/get_java_api.log',
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'index/handler',
            'class' => 'common\exception\ApiExceptionHandler',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    //'basePath' => '@app/messages',
                    //'sourceLanguage' => 'en-US',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/api' => 'api.php',
                    ],
                ],
            ],
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'params' => $params,
/*
    'view' => [
        'themes' => [
            'pathMap' => [
                '@frontend/views' => '@frontend/themes/pc/views',
                '@frontend/mobile' => '@frontend/themes/mobile/views',
            ],
            'baseUrl' => '@web/themes/pc',
        ],
    ],
*/
];
