<?php

namespace backend\controllers;

use Yii;
use backend\search\PracticeUserSearch;
use backend\models\PracticeUser;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * PracticeUserController implements the CRUD actions for PracticeUser model.
 */
class PracticeUserController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => PracticeUser::className(),
                'data' => function(){
                    
                        $searchModel = new PracticeUserSearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => PracticeUser::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => PracticeUser::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => PracticeUser::className(),
            ],
        ];
    }
}
