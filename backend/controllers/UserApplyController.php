<?php

namespace backend\controllers;

use Yii;
use backend\search\UserApplySearch;
use backend\models\UserApply;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * UserApplyController implements the CRUD actions for UserApply model.
 */
class UserApplyController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => UserApply::className(),
                'data' => function(){
                    
                        $searchModel = new UserApplySearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => UserApply::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => UserApply::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => UserApply::className(),
            ],
        ];
    }
}
