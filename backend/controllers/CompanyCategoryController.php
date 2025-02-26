<?php

namespace backend\controllers;

use Yii;
use backend\search\CompanyCategorySearch;
use backend\models\CompanyCategory;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * CompanyCategoryController implements the CRUD actions for CompanyCategory model.
 */
class CompanyCategoryController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => CompanyCategory::className(),
                'data' => function(){
                    
                        $searchModel = new CompanyCategorySearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => CompanyCategory::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => CompanyCategory::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => CompanyCategory::className(),
            ],
        ];
    }
}
