<?php

namespace backend\controllers;

use Yii;
use backend\search\UserMessageSearch;
use backend\models\UserMessage;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * UserMessageController implements the CRUD actions for UserMessage model.
 */
class UserMessageController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => UserMessage::className(),
                'data' => function(){
                    
                        $searchModel = new UserMessageSearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => UserMessage::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => UserMessage::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => UserMessage::className(),
            ],
        ];
    }
}
