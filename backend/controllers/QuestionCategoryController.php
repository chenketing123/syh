<?php

namespace backend\controllers;

use Yii;
use backend\search\QuestionCategorySearch;
use backend\models\QuestionCategory;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * QuestionCategoryController implements the CRUD actions for QuestionCategory model.
 */
class QuestionCategoryController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => QuestionCategory::className(),
                'data' => function(){
                    
                        $searchModel = new QuestionCategorySearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => QuestionCategory::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => QuestionCategory::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => QuestionCategory::className(),
            ],
        ];
    }
}
