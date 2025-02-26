<?php

namespace backend\controllers;

use Yii;
use backend\search\MessageSearch;
use backend\models\Message;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => Message::className(),
                'data' => function(){
                    
                        $searchModel = new MessageSearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Message::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Message::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Message::className(),
            ],
        ];
    }
}
