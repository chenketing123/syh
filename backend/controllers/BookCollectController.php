<?php

namespace backend\controllers;

use Yii;
use backend\search\BookCollectSearch;
use backend\models\BookCollect;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * BookCollectController implements the CRUD actions for BookCollect model.
 */
class BookCollectController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => BookCollect::className(),
                'data' => function(){
                    
                        $searchModel = new BookCollectSearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => BookCollect::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => BookCollect::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => BookCollect::className(),
            ],
        ];
    }
}
