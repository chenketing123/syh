<?php

namespace backend\controllers;

use Yii;
use backend\search\UserHistorySearch;
use backend\models\UserHistory;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * UserHistoryController implements the CRUD actions for UserHistory model.
 */
class UserHistoryController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => UserHistory::className(),
                'data' => function(){
                    
                        $searchModel = new UserHistorySearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => UserHistory::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => UserHistory::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => UserHistory::className(),
            ],
        ];
    }
}
