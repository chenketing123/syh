<?php

namespace backend\controllers;

use Yii;
use backend\search\ShopSearch;
use backend\models\Shop;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * ShopController implements the CRUD actions for Shop model.
 */
class ShopController extends MController
{

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => Shop::className(),
                'data' => function(){
                    
                        $searchModel = new ShopSearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Shop::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Shop::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Shop::className(),
            ],
        ];
    }

    public function actionView(){
        $this->render('view');
    }
}
