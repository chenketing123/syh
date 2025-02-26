<?php

namespace backend\controllers;

use Yii;
use backend\search\QuestionAnswerSearch;
use backend\models\QuestionAnswer;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;

/**
 * QuestionAnswerController implements the CRUD actions for QuestionAnswer model.
 */
class QuestionAnswerController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => QuestionAnswer::className(),
                'data' => function(){
                    
                        $searchModel = new QuestionAnswerSearch();
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => QuestionAnswer::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => QuestionAnswer::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => QuestionAnswer::className(),
            ],
        ];
    }
}
