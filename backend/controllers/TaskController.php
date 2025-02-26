<?php

namespace backend\controllers;

use common\components\Helper;
use OSS\OssClient;
use Yii;
use backend\search\TaskSearch;
use backend\models\Task;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use yii\base\BaseObject;
use yii\web\UploadedFile;

if (is_file(__DIR__ . '/aliyun-oss-php-sdk-master/autoload.php')) {
    require_once __DIR__ . '/aliyun-oss-php-sdk-master/autoload.php';
}
if (is_file(__DIR__ . '/aliyun-oss-php-sdk-master/vendor/autoload.php')) {
    require_once __DIR__ . '/aliyun-oss-php-sdk-master/vendor/autoload.php';
}

use OSS\Core\OssException;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => Task::className(),
                'data' => function(){
                    
                        $searchModel = new TaskSearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
//            'create' => [
//                'class' => CreateAction::className(),
//                'modelClass' => Task::className(),
//            ],
//            'update' => [
//                'class' => UpdateAction::className(),
//                'modelClass' => Task::className(),
//            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Task::className(),
            ],
        ];
    }


}
