<?php

namespace backend\controllers;

use Yii;
use backend\search\TeamBookSearch;
use backend\models\TeamBook;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * TeamBookController implements the CRUD actions for TeamBook model.
 */
class TeamBookController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => TeamBook::className(),
                'data' => function(){
                    
                        $searchModel = new TeamBookSearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => TeamBook::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => TeamBook::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => TeamBook::className(),
            ],
        ];
    }
}
