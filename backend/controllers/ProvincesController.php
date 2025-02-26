<?php
/**
 * 系统配置控制器
 */

namespace backend\controllers;
use backend\actions\IndexAction;
use backend\search\ProvincesSearch;
use yii;
use backend\models\Provinces;
use yii\helpers\Html;

class ProvincesController extends MController
{
    /**
     * 首页
     */

    public function actions()
    {
        return [
            'index' => [
                'class' => IndexAction::className(),
                'modelClass' => Provinces::className(),
                'data' => function(){

                    $searchModel = new ProvincesSearch();
                    $searchModel->level=2;
                    $dataProvider = $searchModel->search(Yii::$app->getRequest()->getQueryParams());
                    return [
                        'dataProvider' => $dataProvider,
                        'searchModel' => $searchModel,
                    ];

                }
            ],
        ];
    }


}