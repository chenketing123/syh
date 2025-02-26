<?php

namespace backend\controllers;

use Yii;
use backend\search\QuestionSearch;
use backend\models\Question;
use backend\actions\CreateAction;
use backend\actions\UpdateAction;
use backend\actions\IndexAction;
use backend\actions\DeleteAction;
use yii\base\BaseObject;

/**
 * QuestionController implements the CRUD actions for question model.
 */
class QuestionController extends MController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => Question::className(),
                'data' => function(){
                    
                        $searchModel = new QuestionSearch();
                        $searchModel->type=1;
                        $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                        return [
                            'dataProvider' => $dataProvider,
                            'searchModel' => $searchModel,
                        ];
                    
                }
            ],
            'index2' => [
                'class' => IndexAction::className(),
                'modelClass' => Question::className(),
                'data' => function(){

                    $searchModel = new QuestionSearch();
                    $searchModel->type=2;
                    $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                    return [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                    ];

                }
            ],
            'create' => [
                'class' => CreateAction::className(),
                'modelClass' => Question::className(),
            ],
            'update' => [
                'class' => UpdateAction::className(),
                'modelClass' => Question::className(),
            ],
            'delete' => [
                'class' => DeleteAction::className(),
                'modelClass' => Question::className(),
            ],
        ];
    }

    public function actionTrue(){
        $id=Yii::$app->request->get('id');
        $model=Question::findOne($id);
        if($model and $model->status==1){
            $model->status=2;
            $model->save();
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionFalse(){
        $id=Yii::$app->request->get('id');
        $model=Question::findOne($id);
        if($model and $model->status==1){
            $model->status=3;
            $model->save();
            return $this->redirect(Yii::$app->request->referrer);
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
}
