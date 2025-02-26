<?php

namespace backend\controllers;

use Yii;
use backend\search\UserIconSearch;
use backend\models\UserIcon;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * UserIconController implements the CRUD actions for UserIcon model.
 */
class UserIconController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => UserIcon::className(),
                'data' => function(){
                    
                        $searchModel = new UserIconSearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => UserIcon::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => UserIcon::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => UserIcon::className(),
            ],
        ];
    }
}
