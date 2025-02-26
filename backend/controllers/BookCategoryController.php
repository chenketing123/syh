<?php

namespace backend\controllers;

use Yii;
use backend\search\BookCategorySearch;
use backend\models\BookCategory;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * BookCategoryController implements the CRUD actions for BookCategory model.
 */
class BookCategoryController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => BookCategory::className(),
                'data' => function(){
                    
                        $searchModel = new BookCategorySearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => BookCategory::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => BookCategory::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => BookCategory::className(),
            ],
        ];
    }
}
