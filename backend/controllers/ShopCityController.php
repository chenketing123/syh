<?php

namespace backend\controllers;

use Yii;
use backend\search\ShopCitySearch;
use backend\models\ShopCity;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * ShopCityController implements the CRUD actions for ShopCity model.
 */
class ShopCityController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => ShopCity::className(),
                'data' => function(){
                    
                        $searchModel = new ShopCitySearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => ShopCity::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => ShopCity::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => ShopCity::className(),
            ],
        ];
    }
}
