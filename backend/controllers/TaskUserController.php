<?php

namespace backend\controllers;

use Yii;
use backend\search\TaskUserSearch;
use backend\models\TaskUser;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * TaskUserController implements the CRUD actions for TaskUser model.
 */
class TaskUserController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => TaskUser::className(),
                'data' => function(){
                    
                        $searchModel = new TaskUserSearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => TaskUser::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => TaskUser::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => TaskUser::className(),
            ],
        ];
    }
}
